import React, { useState, useEffect } from 'react';
import axios from 'axios';
import { Link } from 'react-router-dom';

//contract==expedition
const RenovationsList = () => {
  const [renovations, setRenovations] = useState([]);
  const [description, setDescription] = useState('');          // For filtering by title
  const [cost, setCost] = useState('');  // For filtering by description
  const [building, setBuilding] = useState('');    // For filtering by employee name
  const [successMessage, setSuccessMessage] = useState('');

  // Function to fetch contracts with filters applied
  const fetchRenovations = () => {
    axios.get(`http://localhost:8080/api/renovations?description=${description}&cost=${cost}&building=${building}`)
      .then(response => {
        setRenovations(response.data);
      })
      .catch(error => {
        console.error('There was an error fetching the renovations!', error);
      });
  };

  // Call fetchContracts on component mount and whenever the filters change
  useEffect(() => {
    fetchRenovations();
  }, [description, cost, building]); // Refetch contracts whenever a filter changes

  // Handlers for filter changes
  const handleDescriptionChange = (e) => {
    setDescription(e.target.value); // Update title filter
  };

  const handleCostChange = (e) => {
    setCost(e.target.value); // Update description filter
  };

  const handleBuildingChange = (e) => {
    setBuilding(e.target.value); // Update employee filter
  };

  // Function to delete a contract
  const deleteRenovation = (id) => {
    axios.delete(`http://localhost:8080/api/renovations/${id}`)
      .then(() => {
        setSuccessMessage('Renovation deleted successfully!');
        fetchRenovations(); // Refresh the list after deletion
        setTimeout(() => setSuccessMessage(''), 3000); // Clear success message after 3 seconds
      })
      .catch(error => {
        console.error('There was an error deleting the renovation!', error);
      });
  };

  return (
    <div className="container">
      <h2>Renovations List</h2>
      
      {/* Search Filters */}
      <div className="filters">
        <input 
          type="text" 
          placeholder="Description" 
          value={description} 
          onChange={handleDescriptionChange} 
          className="form-control" 
          style={{ display: 'inline-block', width: '200px', marginRight: '10px' }}
        />
        <input 
          type="number" 
          placeholder="Cost" 
          value={cost} 
          onChange={handleCostChange} 
          className="form-control" 
          style={{ display: 'inline-block', width: '200px', marginRight: '10px' }}
        />
        <input 
          type="text" 
          placeholder="Building Name" 
          value={building} 
          onChange={handleBuildingChange} 
          className="form-control" 
          style={{ display: 'inline-block', width: '200px', marginRight: '10px' }}
        />
        <button className="btn btn-primary" onClick={fetchRenovations}>Search</button>
      </div>

      {successMessage && <div className="alert alert-success">{successMessage}</div>} {/* Success message */}

      {/* Add Contract Link */}
      <div className="text-end">
        <Link to="/add-renovation" className="btn btn-primary">Add Renovation</Link>
      </div>

      {/* Contract Table */}
      <table className="table">
        <thead>
          <tr>
            <th>No</th>
            <th>Description</th>
            <th>Cost</th>
            <th>Building</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          {renovations.map((renovation, index) => (
            <tr key={renovation.id}>
              <td>{index + 1}</td>
              <td>{renovation.description}</td>
              <td>{renovation.cost}</td>
              <td>{renovation.building.name}</td>
              <td>
                <Link to={`/edit-renovation/${renovation.id}`} className="btn btn-success">Edit</Link>
                <button className="btn btn-danger" onClick={() => deleteRenovation(renovation.id)}>Delete</button>
              </td>
            </tr>
          ))}
        </tbody>
      </table>
    </div>
  );
};

export default RenovationsList;
