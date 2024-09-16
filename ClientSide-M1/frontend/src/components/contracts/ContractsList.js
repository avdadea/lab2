import React, { useState, useEffect } from 'react';
import axios from 'axios';
import { Link } from 'react-router-dom';

const ContractsList = () => {
  const [contracts, setContracts] = useState([]);
  const [title, setTitle] = useState('');          // For filtering by title
  const [description, setDescription] = useState('');  // For filtering by description
  const [employee, setEmployee] = useState('');    // For filtering by employee name
  const [successMessage, setSuccessMessage] = useState('');

  // Function to fetch contracts with filters applied
  const fetchContracts = () => {
    axios.get(`http://localhost:8080/api/contracts?title=${title}&description=${description}&employee=${employee}`)
      .then(response => {
        setContracts(response.data);
      })
      .catch(error => {
        console.error('There was an error fetching the contracts!', error);
      });
  };

  // Call fetchContracts on component mount and whenever the filters change
  useEffect(() => {
    fetchContracts();
  }, [title, description, employee]); // Refetch contracts whenever a filter changes

  // Handlers for filter changes
  const handleTitleChange = (e) => {
    setTitle(e.target.value); // Update title filter
  };

  const handleDescriptionChange = (e) => {
    setDescription(e.target.value); // Update description filter
  };

  const handleEmployeeChange = (e) => {
    setEmployee(e.target.value); // Update employee filter
  };

  // Function to delete a contract
  const deleteContract = (id) => {
    axios.delete(`http://localhost:8080/api/contracts/${id}`)
      .then(() => {
        setSuccessMessage('Contract deleted successfully!');
        fetchContracts(); // Refresh the list after deletion
        setTimeout(() => setSuccessMessage(''), 3000); // Clear success message after 3 seconds
      })
      .catch(error => {
        console.error('There was an error deleting the contract!', error);
      });
  };

  return (
    <div className="container">
      <h2>Contracts List</h2>
      
      {/* Search Filters */}
      <div className="filters">
        <input 
          type="text" 
          placeholder="Title" 
          value={title} 
          onChange={handleTitleChange} 
          className="form-control" 
          style={{ display: 'inline-block', width: '200px', marginRight: '10px' }}
        />
        <input 
          type="text" 
          placeholder="Description" 
          value={description} 
          onChange={handleDescriptionChange} 
          className="form-control" 
          style={{ display: 'inline-block', width: '200px', marginRight: '10px' }}
        />
        <input 
          type="text" 
          placeholder="Employee Name" 
          value={employee} 
          onChange={handleEmployeeChange} 
          className="form-control" 
          style={{ display: 'inline-block', width: '200px', marginRight: '10px' }}
        />
        <button className="btn btn-primary" onClick={fetchContracts}>Search</button>
      </div>

      {successMessage && <div className="alert alert-success">{successMessage}</div>} {/* Success message */}

      {/* Add Contract Link */}
      <div className="text-end">
        <Link to="/add-contract" className="btn btn-primary">Add Contract</Link>
      </div>

      {/* Contract Table */}
      <table className="table">
        <thead>
          <tr>
            <th>No</th>
            <th>Title</th>
            <th>Description</th>
            <th>Employee</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          {contracts.map((contract, index) => (
            <tr key={contract.id}>
              <td>{index + 1}</td>
              <td>{contract.title}</td>
              <td>{contract.description}</td>
              <td>{contract.employee.name} {contract.employee.surname}</td>
              <td>
                <Link to={`/edit-contract/${contract.id}`} className="btn btn-success">Edit</Link>
                <button className="btn btn-danger" onClick={() => deleteContract(contract.id)}>Delete</button>
              </td>
            </tr>
          ))}
        </tbody>
      </table>
    </div>
  );
};

export default ContractsList;
