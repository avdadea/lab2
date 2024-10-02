import React, { useState, useEffect } from 'react';
import axios from 'axios';
import { useParams, useNavigate } from 'react-router-dom';

const EditAssetPage = () => {
  const { id } = useParams();
  const [brandName, setBrandName] = useState(''); // For asset brand name
  const [productionDate, setProductionDate] = useState(''); // For asset production date
  const [assetTypeId, setAssetTypeId] = useState('');
  const [assetTypes, setAssetTypes] = useState([]);
  const navigate = useNavigate();

  useEffect(() => {
    // Fetch the asset details by ID
    axios.get(`http://localhost:8080/api/assets/${id}`)
      .then(response => {
        setBrandName(response.data.brand_name);
        setProductionDate(response.data.production_date);
        setAssetTypeId(response.data.asset_type_id);
      })
      .catch(error => {
        console.error('There was an error fetching the asset!', error);
      });

    // Fetch the list of asset types for the dropdown
    axios.get('http://localhost:8080/api/asset_types')
      .then(response => {
        setAssetTypes(response.data);
      })
      .catch(error => {
        console.error('There was an error fetching the asset types!', error);
      });
  }, [id]);

  const handleSubmit = (e) => {
    e.preventDefault();

    // Update asset details
    axios.put(`http://localhost:8080/api/assets/${id}`, {
      brand_name: brandName,
      production_date: productionDate,
      asset_type_id: assetTypeId,
    })
    .then(response => {
      console.log('Asset updated!', response.data);
      navigate('/assets'); // Redirect to assets list after successful update
    })
    .catch(error => {
      console.error('There was an error updating the asset!', error);
    });
  };

  return (
    <div>
      <h2>Edit Asset</h2>
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
        <button type="submit" className="btn btn-primary">Update Asset</button>
      </form>
    </div>
  );
};

export default EditAssetPage;
