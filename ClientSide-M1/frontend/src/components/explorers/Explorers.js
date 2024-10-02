import React, { useState, useEffect } from 'react';
import axios from 'axios';
import { Link } from 'react-router-dom';

//employee==explorer
const Explorers = () => {
  const [explorers, setExplorers] = useState([]);
  const [name, setName] = useState('');          // For filtering by employee name
  const [nationality, setNationality] = useState('');    // For filtering by employee surname
  const [successMessage, setSuccessMessage] = useState('');

  // Function to fetch employees with filters applied
  const fetchExplorers = () => {
    axios.get(`http://localhost:8080/api/explorers?name=${name}&nationality=${nationality}`)
      .then(response => {
        setExplorers(response.data);
      })
      .catch(error => {
        console.error('There was an error fetching the explorers!', error);
      });
  };

  // Call fetchEmployees on component mount and whenever the filters change
  useEffect(() => {
    fetchExplorers();
  }, [name, nationality]); // Refetch employees whenever a filter changes

  // Handlers for filter changes
  const handleNameChange = (e) => {
    setName(e.target.value); // Update name filter
  };

  const handleNationalityChange = (e) => {
    setNationality(e.target.value); // Update surname filter
  };

  // Function to delete an employee
  const deleteExplorer = (id) => {
    axios.delete(`http://localhost:8080/api/explorers/${id}`)
      .then(() => {
        setSuccessMessage('Explorer deleted successfully!');
        fetchExplorers(); // Refresh the list after deletion
        setTimeout(() => setSuccessMessage(''), 3000); // Clear success message after 3 seconds
      })
      .catch(error => {
        console.error('There was an error deleting the explorer!', error);
      });
  };

  return (
    <div className="container">
      <h2>Explorers List</h2>

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
          placeholder="Nationality" 
          value={nationality} 
          onChange={handleNationalityChange} 
          className="form-control" 
          style={{ display: 'inline-block', width: '200px', marginRight: '10px' }}
        />
        <button className="btn btn-primary" onClick={fetchExplorers}>Search</button>
      </div>

      {successMessage && <div className="alert alert-success">{successMessage}</div>} {/* Success message */}

      {/* Add Employee Link */}
      <div className="text-end">
        <Link to="/add-explorer" className="btn btn-primary">Add Explorer</Link>
      </div>

      {/* Employee Table */}
      <table className="table">
        <thead>
          <tr>
            <th>No</th>
            <th>Name</th>
            <th>Nationality</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          {explorers.map((explorer, index) => (
            <tr key={explorer.id}>
              <td>{index + 1}</td>
              <td>{explorer.name}</td>
              <td>{explorer.nationality}</td>
              <td>
                <Link to={`/edit-explorer/${explorer.id}`} className="btn btn-success">Edit</Link>
                <button className="btn btn-danger" onClick={() => deleteExplorer(explorer.id)}>Delete</button>
              </td>
            </tr>
          ))}
        </tbody>
      </table>
    </div>
  );
};

export default Explorers;
