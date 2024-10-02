import React, { useState, useEffect } from 'react';
import axios from 'axios';
import { useParams, useNavigate } from 'react-router-dom';

const EditAssetTypePage = () => {
  const { id } = useParams(); // Get the AssetType ID from the URL
  const [name, setName] = useState('');
  const [isActive, setIsActive] = useState(true); // default to active status

  const navigate = useNavigate();

  useEffect(() => {
    // Fetch the AssetType details by ID
    axios.get(`http://localhost:8080/api/asset_types/${id}`)
      .then(response => {
        setName(response.data.name);
        setIsActive(response.data.is_active); // Set the active status from the API response
      })
      .catch(error => {
        console.error('There was an error fetching the asset type!', error);
      });
  }, [id]);

  const handleSubmit = (e) => {
    e.preventDefault();

    // Convert the dropdown value into a boolean
    axios.put(`http://localhost:8080/api/asset_types/${id}`, {
      name: name,
      is_active: isActive === 'true', // Ensure it's sent as a boolean
    })
    .then(response => {
      console.log('Asset Type updated!', response.data);
      navigate('/asset_types'); // Redirect to the asset types list after successful update
    })
    .catch(error => {
      console.error('There was an error updating the asset type!', error);
    });
  };

  return (
    <div className="container">
      <h2>Edit Asset Type</h2>
      <form onSubmit={handleSubmit}>
        <div className="form-group">
          <label>Name:</label>
          <input type="text" className="form-control" value={name} onChange={(e) => setName(e.target.value)} />
        </div>
        <div className="form-group">
          <label>Is Active:</label>
          <select
            className="form-control"
            value={isActive ? 'true' : 'false'} // Set the current value as 'true' or 'false'
            onChange={(e) => setIsActive(e.target.value)}
          >
            <option value="true">Active</option>
            <option value="false">Not Active</option>
          </select>
        </div>
        <button type="submit" className="btn btn-primary">Update Asset Type</button>
      </form>
    </div>
  );
};

export default EditAssetTypePage;
