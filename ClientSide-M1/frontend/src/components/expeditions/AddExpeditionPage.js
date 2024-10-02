import React, { useState, useEffect } from 'react';
import axios from 'axios';
import { useNavigate } from 'react-router-dom';

const AddExpeditionPage = () => {
  const [destination, setDestination] = useState('');          // For filtering by title
  const [crewSize, setCrewSize] = useState('');  // For filtering by description
  const [explorerId, setExplorerId] = useState('');
  const [explorers, setExplorers] = useState([]);
  const navigate = useNavigate();

  useEffect(() => {
    axios.get('http://localhost:8080/api/explorers')
      .then(response => {
        setExplorers(response.data);
      })
      .catch(error => {
        console.error('There was an error fetching the explorers!', error);
      });
  }, []);

  const handleSubmit = (e) => {
    e.preventDefault();

    axios.post('http://localhost:8080/api/expeditions', {
      destination: destination,
      crew_size: crewSize,
      explorer_id: explorerId,
    })
    .then(response => {
      console.log('Expedition added!', response.data);
      navigate('/expeditions');
    })
    .catch(error => {
      console.error('There was an error adding the expedition!', error);
    });
  };

  return (
    <div>
      <h2>Add an Expedition</h2>
      <form onSubmit={handleSubmit}>
        <div className="form-group">
          <label>Destination:</label>
          <input type="text" className="form-control" value={destination} onChange={(e) => setDestination(e.target.value)} />
        </div>
        <div className="form-group">
          <label>Crew Size:</label>
          <input type="number" className="form-control" value={crewSize} onChange={(e) => setCrewSize(e.target.value)} />
        </div>
        <div className="form-group">
          <label>Explorer:</label>
          <select className="form-control" value={explorerId} onChange={(e) => setExplorerId(e.target.value)}>
            <option value="">Select Explorer</option>
            {explorers.map(explorer => (
              <option key={explorer.id} value={explorer.id}>
                {explorer.name}
              </option>
            ))}
          </select>
        </div>
        <button type="submit" className="btn btn-primary">Add Expedition</button>
      </form>
    </div>
  );
};

export default AddExpeditionPage;
