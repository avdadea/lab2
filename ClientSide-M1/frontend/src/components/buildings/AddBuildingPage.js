import React, { useState } from 'react';
import axios from 'axios';
import { useNavigate } from 'react-router-dom';

//explorer==chef
const AddBuildingPage = () => {
  const [name, setName] = useState('');
  const [location, setLocation] = useState('');    // For filtering by employee surname

  const navigate = useNavigate(); // Use to navigate back to the Directors list after submission

  const handleSubmit = (e) => {
    e.preventDefault();

    axios.post('http://localhost:8080/api/buildings', {
      name: name,
      location: location
    })
    .then(response => {
      console.log('Building added!', response.data);
      navigate('/buildings'); // Redirect to the directors list after successful submission
    })
    .catch(error => {
      console.error('There was an error adding the building!', error);
    });
  };

  return (
    <div className="container">
      <h2>Add a New Building</h2>
      <form onSubmit={handleSubmit}>
        <div className="form-group">
          <label>Name:</label>
          <input type="text" className="form-control" value={name} onChange={(e) => setName(e.target.value)} />
        </div>
        <div className="form-group">
          <label>Location:</label>
          <input type="text" className="form-control" value={location} onChange={(e) => setLocation(e.target.value)} />
        </div>
    
        <button type="submit" className="btn btn-primary">Submit</button>
      </form>
    </div>
  );
};

export default AddBuildingPage;
