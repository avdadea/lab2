import React, { useState, useEffect } from 'react';
import axios from 'axios';
import { Link } from 'react-router-dom';

const Planets = () => {
  const [planets, setPlanets] = useState([]);
  const [name, setName] = useState(''); // For filtering by planet name
  const [type, setType] = useState(''); // For filtering by planet type
  const [successMessage, setSuccessMessage] = useState('');

  // Function to fetch planets with filters applied
  const fetchPlanets = () => {
    axios.get(`http://localhost:8080/api/planets?name=${name}&type=${type}`)
      .then(response => {
        setPlanets(response.data);
      })
      .catch(error => {
        console.error('There was an error fetching the planets!', error);
      });
  };

  // Call fetchPlanets on component mount and whenever the filters change
  useEffect(() => {
    fetchPlanets();
  }, [name, type]); // Refetch planets whenever a filter changes

  // Handlers for filter changes
  const handleNameChange = (e) => {
    setName(e.target.value); // Update name filter
  };

  const handleTypeChange = (e) => {
    setType(e.target.value); // Update type filter
  };

  // Function to soft delete a planet (update is_deleted to true)
  const deletePlanet = (id) => {
    axios.delete(`http://localhost:8080/api/planets/${id}`)
      .then(() => {
        setSuccessMessage('Planet deleted successfully!');
        fetchPlanets(); // Refresh the list after deletion
        setTimeout(() => setSuccessMessage(''), 3000); // Clear success message after 3 seconds
      })
      .catch(error => {
        console.error('There was an error deleting the planet!', error);
      });
  };

  return (
    <div className="container">
      <h2>Planets List</h2>

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
          placeholder="Type" 
          value={type} 
          onChange={handleTypeChange} 
          className="form-control" 
          style={{ display: 'inline-block', width: '200px', marginRight: '10px' }}
        />
        <button className="btn btn-primary" onClick={fetchPlanets}>Search</button>
      </div>

      {successMessage && <div className="alert alert-success">{successMessage}</div>} {/* Success message */}

      {/* Add Planet Link */}
      <div className="text-end">
        <Link to="/add-planet" className="btn btn-primary">Add Planet</Link>
      </div>

      {/* Planet Table */}
      <table className="table">
        <thead>
          <tr>
            <th>No</th>
            <th>Name</th>
            <th>Type</th>
            <th>Is Deleted</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          {planets.map((planet, index) => (
            <tr key={planet.id}>
              <td>{index + 1}</td>
              <td>{planet.name}</td>
              <td>{planet.type}</td>
              <td>{planet.is_deleted ? 'Yes' : 'No'}</td> {/* Show if planet is deleted */}
              <td>
                <Link to={`/edit-planet/${planet.id}`} className="btn btn-success">Edit</Link>
                <button className="btn btn-danger" onClick={() => deletePlanet(planet.id)}>Delete</button> {/* Soft delete by setting isDeleted to true */}
              </td>
            </tr>
          ))}
        </tbody>
      </table>
    </div>
  );
};

export default Planets;
