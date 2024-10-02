import React, { useState, useEffect } from 'react';
import axios from 'axios';
import { Link } from 'react-router-dom';

const SatellitesList = () => {
  const [satellites, setSatellites] = useState([]);
  const [name, setName] = useState('');          // For filtering by title
  const [planet, setPlanet] = useState('');    // For filtering by employee name
  const [successMessage, setSuccessMessage] = useState('');

  // Function to fetch contracts with filters applied
  const fetchSatellites = () => {
    axios.get(`http://localhost:8080/api/satellites?name=${name}&planet=${planet}`)
      .then(response => {
        setSatellites(response.data);
      })
      .catch(error => {
        console.error('There was an error fetching the satellites!', error);
      });
  };

  // Call fetchContracts on component mount and whenever the filters change
  useEffect(() => {
    fetchSatellites();
  }, [name, planet]); // Refetch contracts whenever a filter changes

  // Handlers for filter changes
  const handleNameChange = (e) => {
    setName(e.target.value); // Update title filter
  };
  const handlePlanetChange = (e) => {
    setPlanet(e.target.value); // Update employee filter
  };

  // Function to delete a contract
  const deleteSatellite = (id) => {
    axios.delete(`http://localhost:8080/api/satellites/${id}`)
      .then(() => {
        setSuccessMessage('Satellite deleted successfully!');
        fetchSatellites(); // Refresh the list after deletion
        setTimeout(() => setSuccessMessage(''), 3000); // Clear success message after 3 seconds
      })
      .catch(error => {
        console.error('There was an error deleting the satellite!', error);
      });
  };

  return (
    <div className="container">
      <h2>Satellites List</h2>
      
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
          placeholder="Planet Name" 
          value={planet} 
          onChange={handlePlanetChange} 
          className="form-control" 
          style={{ display: 'inline-block', width: '200px', marginRight: '10px' }}
        />
        <button className="btn btn-primary" onClick={fetchSatellites}>Search</button>
      </div>

      {successMessage && <div className="alert alert-success">{successMessage}</div>} {/* Success message */}

      {/* Add Contract Link */}
      <div className="text-end">
        <Link to="/add-satellite" className="btn btn-primary">Add Satellite</Link>
      </div>

      {/* Contract Table */}
      <table className="table">
        <thead>
          <tr>
            <th>No</th>
            <th>Name</th>
            <th>Is Deleted</th>
            <th>Planet</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          {satellites.map((satellite, index) => (
            <tr key={satellite.id}>
              <td>{index + 1}</td>
              <td>{satellite.name}</td>
              <td>{satellite.is_deleted ? 'Yes' : 'No'}</td> {/* Display Yes if isDeleted is true */}
              <td>{satellite.planet.name}</td>
              <td>
                <Link to={`/edit-satellite/${satellite.id}`} className="btn btn-success">Edit</Link>
                <button className="btn btn-danger" onClick={() => deleteSatellite(satellite.id)}>Delete</button>
              </td>
            </tr>
          ))}
        </tbody>
      </table>
    </div>
  );
};

export default SatellitesList;
