import React, { useState, useEffect } from 'react';
import axios from 'axios';
import { Link } from 'react-router-dom';

//explorer==chef
const Chefs = () => {
  const [chefs, setChefs] = useState([]);
  const [name, setName] = useState('');          // For filtering by employee name
  const [birthYear, setBirthYear] = useState('');    // For filtering by employee surname
  const [successMessage, setSuccessMessage] = useState('');

  // Function to fetch employees with filters applied
  const fetchChefs = () => {
    axios.get(`http://localhost:8080/api/chefs?name=${name}&birth_year=${birthYear}`)
      .then(response => {
        setChefs(response.data);
      })
      .catch(error => {
        console.error('There was an error fetching the chefs!', error);
      });
  };

  // Call fetchEmployees on component mount and whenever the filters change
  useEffect(() => {
    fetchChefs();
  }, [name, birthYear]); // Refetch employees whenever a filter changes

  // Handlers for filter changes
  const handleNameChange = (e) => {
    setName(e.target.value); // Update name filter
  };

  const handleBirthYearChange = (e) => {
    setBirthYear(e.target.value); // Update surname filter
  };

  // Function to delete an employee
  const deleteChef = (id) => {
    axios.delete(`http://localhost:8080/api/chefs/${id}`)
      .then(() => {
        setSuccessMessage('Chef deleted successfully!');
        fetchChefs(); // Refresh the list after deletion
        setTimeout(() => setSuccessMessage(''), 3000); // Clear success message after 3 seconds
      })
      .catch(error => {
        console.error('There was an error deleting the chef!', error);
      });
  };

  return (
    <div className="container">
      <h2>Chefs List</h2>

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
          type="number" 
          placeholder="Birth Year" 
          value={birthYear} 
          onChange={handleBirthYearChange} 
          className="form-control" 
          style={{ display: 'inline-block', width: '200px', marginRight: '10px' }}
        />
        <button className="btn btn-primary" onClick={fetchChefs}>Search</button>
      </div>

      {successMessage && <div className="alert alert-success">{successMessage}</div>} {/* Success message */}

      {/* Add Chef Link */}
      <div className="text-end">
        <Link to="/add-chef" className="btn btn-primary">Add Chef</Link>
      </div>

      {/* Chef Table */}
      <table className="table">
        <thead>
          <tr>
            <th>No</th>
            <th>Name</th>
            <th>Birth Year</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          {chefs.map((chef, index) => (
            <tr key={chef.id}>
              <td>{index + 1}</td>
              <td>{chef.name}</td>
              <td>{chef.birth_year}</td>
              <td>
                <Link to={`/edit-chef/${chef.id}`} className="btn btn-success">Edit</Link>
                <button className="btn btn-danger" onClick={() => deleteChef(chef.id)}>Delete</button>
              </td>
            </tr>
          ))}
        </tbody>
      </table>
    </div>
  );
};

export default Chefs;
