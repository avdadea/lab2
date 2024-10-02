import React, { useState, useEffect } from 'react';
import axios from 'axios';
import { Link } from 'react-router-dom';

//explorer==chef
const Buildings = () => {
  const [buildings, setBuildings] = useState([]);
  const [name, setName] = useState('');          // For filtering by employee name
  const [location, setLocation] = useState('');    // For filtering by employee surname
  const [successMessage, setSuccessMessage] = useState('');

  // Function to fetch employees with filters applied
  const fetchBuildings = () => {
    axios.get(`http://localhost:8080/api/buildings?name=${name}&location=${location}`)
      .then(response => {
        setBuildings(response.data);
      })
      .catch(error => {
        console.error('There was an error fetching the buildings!', error);
      });
  };

  // Call fetchEmployees on component mount and whenever the filters change
  useEffect(() => {
    fetchBuildings();
  }, [name, location]); // Refetch employees whenever a filter changes

  // Handlers for filter changes
  const handleNameChange = (e) => {
    setName(e.target.value); // Update name filter
  };

  const handleLocationChange = (e) => {
    setLocation(e.target.value); // Update surname filter
  };

  // Function to delete an employee
  const deleteBuilding = (id) => {
    axios.delete(`http://localhost:8080/api/buildings/${id}`)
      .then(() => {
        setSuccessMessage('Building deleted successfully!');
        fetchBuildings(); // Refresh the list after deletion
        setTimeout(() => setSuccessMessage(''), 3000); // Clear success message after 3 seconds
      })
      .catch(error => {
        console.error('There was an error deleting the building!', error);
      });
  };

  return (
    <div className="container">
      <h2>Buildings List</h2>

      {/* Search Filters */}
      <div className="filters">
        <input 
          type="text" 
          placeholder="Name" 
          value={name} 
          onChange={handleNameChange} 
          className="form-control" 
          style={{ display: 'inline-block', width: '200px', marginRight: '10px' }}
        />
        <input 
          type="text" 
          placeholder="Location" 
          value={location} 
          onChange={handleLocationChange} 
          className="form-control" 
          style={{ display: 'inline-block', width: '200px', marginRight: '10px' }}
        />
        <button className="btn btn-primary" onClick={fetchBuildings}>Search</button>
      </div>

      {successMessage && <div className="alert alert-success">{successMessage}</div>} {/* Success message */}

      {/* Add Chef Link */}
      <div className="text-end">
        <Link to="/add-building" className="btn btn-primary">Add Building</Link>
      </div>

      {/* Chef Table */}
      <table className="table">
        <thead>
          <tr>
            <th>No</th>
            <th>Name</th>
            <th>Location</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          {buildings.map((building, index) => (
            <tr key={building.id}>
              <td>{index + 1}</td>
              <td>{building.name}</td>
              <td>{building.location}</td>
              <td>
                <Link to={`/edit-building/${building.id}`} className="btn btn-success">Edit</Link>
                <button className="btn btn-danger" onClick={() => deleteBuilding(building.id)}>Delete</button>
              </td>
            </tr>
          ))}
        </tbody>
      </table>
    </div>
  );
};

export default Buildings;
