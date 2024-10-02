import React, { useState, useEffect } from 'react';
import axios from 'axios';
import { Link } from 'react-router-dom';

const PlayersList = () => {
  const [players, setPlayers] = useState([]);
  const [name, setName] = useState('');          // For filtering by name
  const [number, setNumber] = useState('');          // For filtering by number
  const [birthYear, setBirthYear] = useState('');  // For filtering by birth year
  const [team, setTeam] = useState('');    // For filtering by team name
  const [successMessage, setSuccessMessage] = useState('');

  // Function to fetch players with filters applied
  const fetchPlayers = () => {
    axios.get(`http://localhost:8080/api/players?name=${name}&number=${number}&birth_year=${birthYear}&team=${team}`)
      .then(response => {
        setPlayers(response.data);
      })
      .catch(error => {
        console.error('There was an error fetching the players!', error);
      });
  };

  // Call fetchPlayers on component mount and whenever the filters change
  useEffect(() => {
    fetchPlayers();
  }, [name, number, birthYear, team]); // Refetch contracts whenever a filter changes

  // Handlers for filter changes
  const handleNameChange = (e) => {
    setName(e.target.value); // Update name filter
  };
  const handleNumberChange = (e) => {
    setNumber(e.target.value); // Update number filter
  };

  const handleBirthYearChange = (e) => {
    setBirthYear(e.target.value); // Update birth year filter
  };

  const handleTeamChange = (e) => {
    setTeam(e.target.value); // Update team filter
  };

  // Function to delete a contract
  const deletePlayer = (id) => {
    axios.delete(`http://localhost:8080/api/players/${id}`)
      .then(() => {
        setSuccessMessage('Player deleted successfully!');
        fetchPlayers(); // Refresh the list after deletion
        setTimeout(() => setSuccessMessage(''), 3000); // Clear success message after 3 seconds
      })
      .catch(error => {
        console.error('There was an error deleting the player!', error);
      });
  };

  return (
    <div className="container">
      <h2>Players List</h2>
      
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
          placeholder="Number" 
          value={number} 
          onChange={handleNumberChange} 
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
        <input 
          type="text" 
          placeholder="Team Name" 
          value={team} 
          onChange={handleTeamChange} 
          className="form-control" 
          style={{ display: 'inline-block', width: '200px', marginRight: '10px' }}
        />
        <button className="btn btn-primary" onClick={fetchPlayers}>Search</button>
      </div>

      {successMessage && <div className="alert alert-success">{successMessage}</div>} {/* Success message */}

      {/* Add Player Link */}
      <div className="text-end">
        <Link to="/add-player" className="btn btn-primary">Add Player</Link>
      </div>

      {/* Player Table */}
      <table className="table">
        <thead>
          <tr>
            <th>No</th>
            <th>Name</th>
            <th>Number</th>
            <th>Birth Year</th>
            <th>Team</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          {players.map((player, index) => (
            <tr key={player.id}>
              <td>{index + 1}</td>
              <td>{player.name}</td>
              <td>{player.number}</td>
              <td>{player.birth_year}</td>
              <td>{player.team.name}</td>
              <td>
                <Link to={`/edit-player/${player.id}`} className="btn btn-success">Edit</Link>
                <button className="btn btn-danger" onClick={() => deletePlayer(player.id)}>Delete</button>
              </td>
            </tr>
          ))}
        </tbody>
      </table>
    </div>
  );
};

export default PlayersList
;
