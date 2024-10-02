import React, { useState, useEffect } from 'react';
import axios from 'axios';
import { Link } from 'react-router-dom';

const AssetTypes = () => {
  const [assetTypes, setAssetTypes] = useState([]);
  const [name, setName] = useState('');          // For filtering by asset type name
  const [successMessage, setSuccessMessage] = useState('');

  // Function to fetch asset types with filters applied
  const fetchAssetTypes = () => {
    axios.get(`http://localhost:8080/api/asset_types?name=${name}`)
      .then(response => {
        setAssetTypes(response.data);
      })
      .catch(error => {
        console.error('There was an error fetching the asset types!', error);
      });
  };

  // Call fetchAssetTypes on component mount and whenever the filters change
  useEffect(() => {
    fetchAssetTypes();
  }, [name]); // Refetch asset types whenever a filter changes

  // Handlers for filter changes
  const handleNameChange = (e) => {
    setName(e.target.value); // Update name filter
  };

  // Function to delete an asset type
  const deleteAssetType = (id) => {
    axios.delete(`http://localhost:8080/api/asset_types/${id}`)
      .then(() => {
        setSuccessMessage('Asset Type deleted successfully!');
        fetchAssetTypes(); // Refresh the list after deletion
        setTimeout(() => setSuccessMessage(''), 3000); // Clear success message after 3 seconds
      })
      .catch(error => {
        console.error('There was an error deleting the asset type!', error);
      });
  };

  return (
    <div className="container">
      <h2>Asset Types List</h2>

      {/* Search Filters */}
      <div className="filters">
        <input 
          type="text" 
          placeholder="Name" 
          value={name} 
          onChange={handleNameChange} 
          className="form-control" 
          style={{ display: 'inline-block', width: '200px', marginRight: '10px' }}
        />
       
        <button className="btn btn-primary" onClick={fetchAssetTypes}>Search</button>
      </div>

      {successMessage && <div className="alert alert-success">{successMessage}</div>} {/* Success message */}

      {/* Add Asset Type Link */}
      <div className="text-end">
        <Link to="/add-asset_type" className="btn btn-primary">Add Asset Type</Link>
      </div>

      {/* Asset Type Table */}
      <table className="table">
        <thead>
          <tr>
            <th>No</th>
            <th>Name</th>
            <th>Is Active</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          {assetTypes.map((asset_type, index) => (
            <tr key={asset_type.id}>
              <td>{index + 1}</td>
              <td>{asset_type.name}</td>
              <td>{asset_type.is_active ? 'Yes' : 'No'}</td> {/* Show if asset type is active */}
              <td>
                <Link to={`/edit-asset_type/${asset_type.id}`} className="btn btn-success">Edit</Link>
                <button className="btn btn-danger" onClick={() => deleteAssetType(asset_type.id)}>Delete</button>
              </td>
            </tr>
          ))}
        </tbody>
      </table>
    </div>
  );
};

export default AssetTypes;
