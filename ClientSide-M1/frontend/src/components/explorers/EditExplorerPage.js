import React, { useState, useEffect } from 'react';
import axios from 'axios';
import { useParams, useNavigate } from 'react-router-dom';


//employee==explorer
const EditExplorerPage = () => {
  const { id } = useParams(); // Get the director ID from the URL
  const [name, setName] = useState('');
  const [nationality, setNationality] = useState('');

  const navigate = useNavigate();

  useEffect(() => {
    // Fetch the director details by ID
    axios.get(`http://localhost:8080/api/explorers/${id}`)
      .then(response => {
        setName(response.data.name);
        setNationality(response.data.nationality);
      })
      .catch(error => {
        console.error('There was an error fetching the explorer!', error);
      });
  }, [id]);

  const handleSubmit = (e) => {
    e.preventDefault();

    axios.put(`http://localhost:8080/api/explorers/${id}`, {
      name: name,
      nationality: nationality
    })
    .then(response => {
      console.log('Explorer updated!', response.data);
      navigate('/explorers'); // Redirect to the directors list after successful update
    })
    .catch(error => {
      console.error('There was an error updating the explorer!', error);
    });
  };

  return (
    <div className="container">
      <h2>Edit Explorer</h2>
      <form onSubmit={handleSubmit}>
        <div className="form-group">
          <label>Name:</label>
          <input type="text" className="form-control" value={name} onChange={(e) => setName(e.target.value)} />
        </div>
        <div className="form-group">
          <label>Nationality:</label>
          <input type="text" className="form-control" value={nationality} onChange={(e) => setNationality(e.target.value)} />
        </div>
        <button type="submit" className="btn btn-primary">Update Explorer</button>
      </form>
    </div>
  );
};

export default EditExplorerPage;
