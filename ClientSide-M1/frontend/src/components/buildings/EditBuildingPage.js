import React, { useState, useEffect } from 'react';
import axios from 'axios';
import { useParams, useNavigate } from 'react-router-dom';


//employee==explorer
const EditBuildingPage = () => {
  const { id } = useParams(); // Get the director ID from the URL
  const [name, setName] = useState('');
  const [location, setLocation] = useState('');    // For filtering by employee surname

  const navigate = useNavigate();

  useEffect(() => {
    // Fetch the director details by ID
    axios.get(`http://localhost:8080/api/buildings/${id}`)
      .then(response => {
        setName(response.data.name);
        setLocation(response.data.location);
      })
      .catch(error => {
        console.error('There was an error fetching the building!', error);
      });
  }, [id]);

  const handleSubmit = (e) => {
    e.preventDefault();

    axios.put(`http://localhost:8080/api/buildings/${id}`, {
      name: name,
      location: location
    })
    .then(response => {
      console.log('Building updated!', response.data);
      navigate('/buildings'); // Redirect to the directors list after successful update
    })
    .catch(error => {
      console.error('There was an error updating the building!', error);
    });
  };

  return (
    <div className="container">
      <h2>Edit Building</h2>
      <form onSubmit={handleSubmit}>
        <div className="form-group">
          <label>Name:</label>
          <input type="text" className="form-control" value={name} onChange={(e) => setName(e.target.value)} />
        </div>
        <div className="form-group">
          <label>Location:</label>
          <input type="text" className="form-control" value={location} onChange={(e) => setLocation(e.target.value)} />
        </div>
    
        <button type="submit" className="btn btn-primary">Update Building</button>
      </form>
    </div>
  );
};

export default EditBuildingPage;
