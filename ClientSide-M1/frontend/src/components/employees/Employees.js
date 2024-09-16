import React, { useState, useEffect } from 'react';
import axios from 'axios';
import { Link } from 'react-router-dom';

const Employees = () => {
  const [employees, setEmployees] = useState([]);
  const [name, setName] = useState('');          // For filtering by employee name
  const [surname, setSurname] = useState('');    // For filtering by employee surname
  const [successMessage, setSuccessMessage] = useState('');

  // Function to fetch employees with filters applied
  const fetchEmployees = () => {
    axios.get(`http://localhost:8080/api/employees?name=${name}&surname=${surname}`)
      .then(response => {
        setEmployees(response.data);
      })
      .catch(error => {
        console.error('There was an error fetching the employees!', error);
      });
  };

  // Call fetchEmployees on component mount and whenever the filters change
  useEffect(() => {
    fetchEmployees();
  }, [name, surname]); // Refetch employees whenever a filter changes

  // Handlers for filter changes
  const handleNameChange = (e) => {
    setName(e.target.value); // Update name filter
  };

  const handleSurnameChange = (e) => {
    setSurname(e.target.value); // Update surname filter
  };

  // Function to delete an employee
  const deleteEmployee = (id) => {
    axios.delete(`http://localhost:8080/api/employees/${id}`)
      .then(() => {
        setSuccessMessage('Employee deleted successfully!');
        fetchEmployees(); // Refresh the list after deletion
        setTimeout(() => setSuccessMessage(''), 3000); // Clear success message after 3 seconds
      })
      .catch(error => {
        console.error('There was an error deleting the employee!', error);
      });
  };

  return (
    <div className="container">
      <h2>Employees List</h2>

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
          placeholder="Surname" 
          value={surname} 
          onChange={handleSurnameChange} 
          className="form-control" 
          style={{ display: 'inline-block', width: '200px', marginRight: '10px' }}
        />
        <button className="btn btn-primary" onClick={fetchEmployees}>Search</button>
      </div>

      {successMessage && <div className="alert alert-success">{successMessage}</div>} {/* Success message */}

      {/* Add Employee Link */}
      <div className="text-end">
        <Link to="/add-employee" className="btn btn-primary">Add Employee</Link>
      </div>

      {/* Employee Table */}
      <table className="table">
        <thead>
          <tr>
            <th>No</th>
            <th>Name</th>
            <th>Surname</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          {employees.map((employee, index) => (
            <tr key={employee.id}>
              <td>{index + 1}</td>
              <td>{employee.name}</td>
              <td>{employee.surname}</td>
              <td>
                <Link to={`/edit-employee/${employee.id}`} className="btn btn-success">Edit</Link>
                <button className="btn btn-danger" onClick={() => deleteEmployee(employee.id)}>Delete</button>
              </td>
            </tr>
          ))}
        </tbody>
      </table>
    </div>
  );
};

export default Employees;
