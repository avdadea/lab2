import React, { useState, useEffect } from 'react';
import axios from 'axios';
import { useNavigate } from 'react-router-dom';

const AddAssetPage = () => {
  const [brandName, setBrandName] = useState('');  // For the asset brand name
  const [productionDate, setProductionDate] = useState('');  // For the asset production date
  const [assetTypeId, setAssetTypeId] = useState('');  // To store the selected asset type
  const [assetTypes, setAssetTypes] = useState([]);  // List of asset types fetched from the API
  const navigate = useNavigate();

  // Fetch asset types when component mounts
  useEffect(() => {
    axios.get('http://localhost:8080/api/asset_types')
      .then(response => {
        setAssetTypes(response.data);
      })
      .catch(error => {
        console.error('There was an error fetching the asset types!', error);
      });
  }, []);

  const handleSubmit = (e) => {
    e.preventDefault();

    axios.post('http://localhost:8080/api/assets', {
      brand_name: brandName,
      production_date: productionDate,
      asset_type_id: assetTypeId,
    })
    .then(response => {
      console.log('Asset added!', response.data);
      navigate('/assets');  // Redirect to the assets list after successful submission
    })
    .catch(error => {
      console.error('There was an error adding the asset!', error);
    });
  };

  return (
    <div className="container">
      <h2>Add a New Asset</h2>
      <form onSubmit={handleSubmit}>
        <div className="form-group">
          <label>Brand Name:</label>
          <input 
            type="text" 
            className="form-control" 
            value={brandName} 
            onChange={(e) => setBrandName(e.target.value)} 
          />
        </div>
        <div className="form-group">
          <label>Production Date:</label>
          <input 
            type="date" 
            className="form-control" 
            value={productionDate} 
            onChange={(e) => setProductionDate(e.target.value)} 
          />
        </div>
        <div className="form-group">
          <label>Asset Type:</label>
          <select 
            className="form-control" 
            value={assetTypeId} 
            onChange={(e) => setAssetTypeId(e.target.value)}
          >
            <option value="">Select Asset Type</option>
            {assetTypes.map(assetType => (
              <option key={assetType.id} value={assetType.id}>
                {assetType.name}
              </option>
            ))}
          </select>
        </div>
        <button type="submit" className="btn btn-primary">Add Asset</button>
      </form>
    </div>
  );
};

export default AddAssetPage;
