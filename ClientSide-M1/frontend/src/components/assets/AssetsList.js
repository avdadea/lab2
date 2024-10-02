import React, { useState, useEffect } from 'react';
import axios from 'axios';
import { Link } from 'react-router-dom';

// Assets List Component
const AssetsList = () => {
  const [assets, setAssets] = useState([]);
  const [brandName, setBrandName] = useState('');  // For filtering by brand name
  const [productionDate, setProductionDate] = useState('');  // For filtering by production date
  const [assetType, setAssetType] = useState('');  // For filtering by asset type
  const [successMessage, setSuccessMessage] = useState('');

  // Function to fetch assets with filters applied
  const fetchAssets = () => {
    axios.get(`http://localhost:8080/api/assets?brand_name=${brandName}&production_date=${productionDate}&asset_type=${assetType}`)
      .then(response => {
        setAssets(response.data);
      })
      .catch(error => {
        console.error('There was an error fetching the assets!', error);
      });
  };

  // Fetch assets on component mount and whenever the filters change
  useEffect(() => {
    fetchAssets();
  }, [brandName, productionDate, assetType]);

  // Handlers for filter changes
  const handleBrandNameChange = (e) => {
    setBrandName(e.target.value);
  };

  const handleProductionDateChange = (e) => {
    setProductionDate(e.target.value);
  };

  const handleAssetTypeChange = (e) => {
    setAssetType(e.target.value);
  };

  // Function to delete an asset
  const deleteAsset = (id) => {
    axios.delete(`http://localhost:8080/api/assets/${id}`)
      .then(() => {
        setSuccessMessage('Asset deleted successfully!');
        fetchAssets(); // Refresh the list after deletion
        setTimeout(() => setSuccessMessage(''), 3000); // Clear success message after 3 seconds
      })
      .catch(error => {
        console.error('There was an error deleting the asset!', error);
      });
  };

  return (
    <div className="container">
      <h2>Assets List</h2>
      
      {/* Search Filters */}
      <div className="filters">
        <input 
          type="text" 
          placeholder="Brand Name" 
          value={brandName} 
          onChange={handleBrandNameChange} 
          className="form-control" 
          style={{ display: 'inline-block', width: '200px', marginRight: '10px' }}
        />
        <input 
          type="date" 
          placeholder="Production Date" 
          value={productionDate} 
          onChange={handleProductionDateChange} 
          className="form-control" 
          style={{ display: 'inline-block', width: '200px', marginRight: '10px' }}
        />
        <input 
          type="text" 
          placeholder="Asset Type" 
          value={assetType} 
          onChange={handleAssetTypeChange} 
          className="form-control" 
          style={{ display: 'inline-block', width: '200px', marginRight: '10px' }}
        />
        <button className="btn btn-primary" onClick={fetchAssets}>Search</button>
      </div>

      {successMessage && <div className="alert alert-success">{successMessage}</div>} {/* Success message */}

      {/* Add Asset Link */}
      <div className="text-end">
        <Link to="/add-asset" className="btn btn-primary">Add Asset</Link>
      </div>

      {/* Assets Table */}
      <table className="table">
        <thead>
          <tr>
            <th>No</th>
            <th>Brand Name</th>
            <th>Production Date</th>
            <th>Asset Type</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          {assets.map((asset, index) => (
            <tr key={asset.id}>
              <td>{index + 1}</td>
              <td>{asset.brand_name}</td>
              <td>{new Date(asset.production_date).toLocaleDateString()}</td> {/* Format the date */}
              <td>{asset.asset_type.name}</td> {/* Assuming the asset_type relation has a 'name' field */}
              <td>
                <Link to={`/edit-asset/${asset.id}`} className="btn btn-success">Edit</Link>
                <button className="btn btn-danger" onClick={() => deleteAsset(asset.id)}>Delete</button>
              </td>
            </tr>
          ))}
        </tbody>
      </table>
    </div>
  );
};

export default AssetsList;
