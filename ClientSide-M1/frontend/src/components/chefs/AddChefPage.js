import React, { useState } from 'react';
import axios from 'axios';
import { useNavigate } from 'react-router-dom';

//explorer==chef
const AddChefPage = () => {
  const [name, setName] = useState('');
  const [birthYear, setBirthYear] = useState('');    // For filtering by employee surname

  const navigate = useNavigate(); // Use to navigate back to the Directors list after submission

  const handleSubmit = (e) => {
    e.preventDefault();

    axios.post('http://localhost:8080/api/chefs', {
      name: name,
      birth_year: birthYear
    })
    .then(response => {
      console.log('Chef added!', response.data);
      navigate('/chefs'); // Redirect to the directors list after successful submission
    })
    .catch(error => {
      console.error('There was an error adding the chef!', error);
    });
  };

  return (
    <div className="container">
      <h2>Add a New Chef</h2>
      <form onSubmit={handleSubmit}>
        <div className="form-group">
          <label>Name:</label>
          <input type="text" className="form-control" value={name} onChange={(e) => setName(e.target.value)} />
        </div>
        <div className="form-group">
          <label>Birth Year:</label>
          <input type="text" className="form-control" value={birthYear} onChange={(e) => setBirthYear(e.target.value)} />
        </div>
    
        <button type="submit" className="btn btn-primary">Submit</button>
      </form>
    </div>
  );
};

export default AddChefPage;
