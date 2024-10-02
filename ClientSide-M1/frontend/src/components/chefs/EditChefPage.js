import React, { useState, useEffect } from 'react';
import axios from 'axios';
import { useParams, useNavigate } from 'react-router-dom';


//employee==explorer
const EditChefPage = () => {
  const { id } = useParams(); // Get the director ID from the URL
  const [name, setName] = useState('');
  const [birthYear, setBirthYear] = useState('');    // For filtering by employee surname

  const navigate = useNavigate();

  useEffect(() => {
    // Fetch the director details by ID
    axios.get(`http://localhost:8080/api/chefs/${id}`)
      .then(response => {
        setName(response.data.name);
        setBirthYear(response.data.birth_year);
      })
      .catch(error => {
        console.error('There was an error fetching the chef!', error);
      });
  }, [id]);

  const handleSubmit = (e) => {
    e.preventDefault();

    axios.put(`http://localhost:8080/api/chefs/${id}`, {
      name: name,
      birth_year: birthYear
    })
    .then(response => {
      console.log('Chef updated!', response.data);
      navigate('/chefs'); // Redirect to the directors list after successful update
    })
    .catch(error => {
      console.error('There was an error updating the chef!', error);
    });
  };

  return (
    <div className="container">
      <h2>Edit Chef</h2>
      <form onSubmit={handleSubmit}>
        <div className="form-group">
          <label>Name:</label>
          <input type="text" className="form-control" value={name} onChange={(e) => setName(e.target.value)} />
        </div>
        <div className="form-group">
          <label>Birth Year:</label>
          <input type="text" className="form-control" value={birthYear} onChange={(e) => setBirthYear(e.target.value)} />
        </div>
    
        <button type="submit" className="btn btn-primary">Update Chef</button>
      </form>
    </div>
  );
};

export default EditChefPage;
