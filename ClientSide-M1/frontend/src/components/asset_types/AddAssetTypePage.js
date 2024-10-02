import React, { useState } from 'react';
import axios from 'axios';
import { useNavigate } from 'react-router-dom';

const AddAssetTypePage = () => {
  const [name, setName] = useState('');
  const [isActive, setIsActive] = useState(''); // For dropdown value
  const navigate = useNavigate(); 

  const handleSubmit = (e) => {
    e.preventDefault();

    axios.post('http://localhost:8080/api/asset_types', {
      name: name,
      is_active: isActive === 'Active' // Send true if Active, false if Not Active
    })
    .then(response => {
      console.log('Asset Type added!', response.data);
      navigate('/assetTypes'); // Redirect to the asset types list after submission
    })
    .catch(error => {
      console.error('There was an error adding the asset type!', error);
    });
  };

  return (
    <div className="container">
      <h2>Add a New Asset Type</h2>
      <form onSubmit={handleSubmit}>
        <div className="form-group">
          <label>Name:</label>
          <input 
            type="text" 
            className="form-control" 
            value={name} 
            onChange={(e) => setName(e.target.value)} 
          />
        </div>
        <div className="form-group">
          <label>Is Active:</label>
          <select 
            className="form-control" 
            value={isActive} 
            onChange={(e) => setIsActive(e.target.value)}
          >
            <option value="">Select Status</option>
            <option value="Active">Active</option>
            <option value="Not Active">Not Active</option>
          </select>
        </div>
    
        <button type="submit" className="btn btn-primary">Submit</button>
      </form>
    </div>
  );
};

export default AddAssetTypePage;
