import React, { useState, useEffect } from 'react';
import axios from 'axios';
import { Link } from 'react-router-dom';

const Teams = () => {
  const [teams, setTeams] = useState([]);
  const [name, setName] = useState('');          // For filtering by asset type name
  const [successMessage, setSuccessMessage] = useState('');

  // Function to fetch teams with filters applied
  const fetchTeams = () => {
    axios.get(`http://localhost:8080/api/teams?name=${name}`)
      .then(response => {
        setTeams(response.data);
      })
      .catch(error => {
        console.error('There was an error fetching the teams!', error);
      });
  };

  // Call fetchTeams on component mount and whenever the filters change
  useEffect(() => {
    fetchTeams();
  }, [name]); // Refetch teams whenever a filter changes

  // Handlers for filter changes
  const handleNameChange = (e) => {
    setName(e.target.value); // Update name filter
  };

  // Function to delete a team
  const deleteTeam = (id) => {
    axios.delete(`http://localhost:8080/api/teams/${id}`)
      .then(() => {
        setSuccessMessage('Team deleted successfully!');
        fetchTeams(); // Refresh the list after deletion
        setTimeout(() => setSuccessMessage(''), 3000); // Clear success message after 3 seconds
      })
      .catch(error => {
        console.error('There was an error deleting the team!', error);
      });
  };

  return (
    <div className="container">
      <h2>Teams List</h2>

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
       
        <button className="btn btn-primary" onClick={fetchTeams}>Search</button>
      </div>

      {successMessage && <div className="alert alert-success">{successMessage}</div>} {/* Success message */}

      {/* Add Team Link */}
      <div className="text-end">
        <Link to="/add-team" className="btn btn-primary">Add Team</Link>
      </div>

      {/* Team Table */}
      <table className="table">
        <thead>
          <tr>
            <th>No</th>
            <th>Name</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          {teams.map((team, index) => (
            <tr key={team.id}>
              <td>{index + 1}</td>
              <td>{team.name}</td>
              <td>
                <Link to={`/edit-team/${team.id}`} className="btn btn-success">Edit</Link>
                <button className="btn btn-danger" onClick={() => deleteTeam(team.id)}>Delete</button>
              </td>
            </tr>
          ))}
        </tbody>
      </table>
    </div>
  );
};

export default Teams;
