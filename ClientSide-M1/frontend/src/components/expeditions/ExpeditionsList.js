import React, { useState, useEffect } from 'react';
import axios from 'axios';
import { Link } from 'react-router-dom';

//contract==expedition
const ExpeditionsList = () => {
  const [expeditions, setExpeditions] = useState([]);
  const [destination, setDestination] = useState('');          // For filtering by title
  const [crewSize, setCrewSize] = useState('');  // For filtering by description
  const [explorer, setExplorer] = useState('');    // For filtering by employee name
  const [successMessage, setSuccessMessage] = useState('');

  // Function to fetch contracts with filters applied
  const fetchExpeditions = () => {
    axios.get(`http://localhost:8080/api/expeditions?destination=${destination}&crew_size=${crewSize}&explorer=${explorer}`)
      .then(response => {
        setExpeditions(response.data);
      })
      .catch(error => {
        console.error('There was an error fetching the expeditions!', error);
      });
  };

  // Call fetchContracts on component mount and whenever the filters change
  useEffect(() => {
    fetchExpeditions();
  }, [destination, crewSize, explorer]); // Refetch contracts whenever a filter changes

  // Handlers for filter changes
  const handleDestinationChange = (e) => {
    setDestination(e.target.value); // Update title filter
  };

  const handleCrewSizeChange = (e) => {
    setCrewSize(e.target.value); // Update description filter
  };

  const handleExplorerChange = (e) => {
    setExplorer(e.target.value); // Update employee filter
  };

  // Function to delete a contract
  const deleteExpedition = (id) => {
    axios.delete(`http://localhost:8080/api/expeditions/${id}`)
      .then(() => {
        setSuccessMessage('Expedition deleted successfully!');
        fetchExpeditions(); // Refresh the list after deletion
        setTimeout(() => setSuccessMessage(''), 3000); // Clear success message after 3 seconds
      })
      .catch(error => {
        console.error('There was an error deleting the expedition!', error);
      });
  };

  return (
    <div className="container">
      <h2>Expeditions List</h2>
      
      {/* Search Filters */}
      <div className="filters">
        <input 
          type="text" 
          placeholder="Destination" 
          value={destination} 
          onChange={handleDestinationChange} 
          className="form-control" 
          style={{ display: 'inline-block', width: '200px', marginRight: '10px' }}
        />
        <input 
          type="number" 
          placeholder="Crew Size" 
          value={crewSize} 
          onChange={handleCrewSizeChange} 
          className="form-control" 
          style={{ display: 'inline-block', width: '200px', marginRight: '10px' }}
        />
        <input 
          type="text" 
          placeholder="Explorer Name" 
          value={explorer} 
          onChange={handleExplorerChange} 
          className="form-control" 
          style={{ display: 'inline-block', width: '200px', marginRight: '10px' }}
        />
        <button className="btn btn-primary" onClick={fetchExpeditions}>Search</button>
      </div>

      {successMessage && <div className="alert alert-success">{successMessage}</div>} {/* Success message */}

      {/* Add Contract Link */}
      <div className="text-end">
        <Link to="/add-expedition" className="btn btn-primary">Add Expedition</Link>
      </div>

      {/* Contract Table */}
      <table className="table">
        <thead>
          <tr>
            <th>No</th>
            <th>Destination</th>
            <th>Crew Size</th>
            <th>Explorer</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          {expeditions.map((expedition, index) => (
            <tr key={expedition.id}>
              <td>{index + 1}</td>
              <td>{expedition.destination}</td>
              <td>{expedition.crew_size}</td>
              <td>{expedition.explorer.name}</td>
              <td>
                <Link to={`/edit-expedition/${expedition.id}`} className="btn btn-success">Edit</Link>
                <button className="btn btn-danger" onClick={() => deleteExpedition(expedition.id)}>Delete</button>
              </td>
            </tr>
          ))}
        </tbody>
      </table>
    </div>
  );
};

export default ExpeditionsList;
