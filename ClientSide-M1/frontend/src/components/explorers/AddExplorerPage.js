import React, { useState } from 'react';
import axios from 'axios';
import { useNavigate } from 'react-router-dom';

//employee==explorer
const AddExplorerPage = () => {
  const [name, setName] = useState('');
  const [nationality, setNationality] = useState('');

  const navigate = useNavigate(); // Use to navigate back to the Directors list after submission

  const handleSubmit = (e) => {
    e.preventDefault();

    axios.post('http://localhost:8080/api/explorers', {
      name: name,
      nationality: nationality
    })
    .then(response => {
      console.log('Explorer added!', response.data);
      navigate('/explorers'); // Redirect to the directors list after successful submission
    })
    .catch(error => {
      console.error('There was an error adding the explorer!', error);
    });
  };

  return (
    <div className="container">
      <h2>Add a New Explorer</h2>
      <form onSubmit={handleSubmit}>
        <div className="form-group">
          <label>Name:</label>
          <input type="text" className="form-control" value={name} onChange={(e) => setName(e.target.value)} />
        </div>
        <div className="form-group">
          <label>Nationality:</label>
          <input type="text" className="form-control" value={nationality} onChange={(e) => setNationality(e.target.value)} />
        </div>
    
        <button type="submit" className="btn btn-primary">Submit</button>
      </form>
    </div>
  );
};

export default AddExplorerPage;
