import React, { useState, useEffect } from 'react';
import axios from 'axios';
import { useNavigate } from 'react-router-dom';

const AddRenovationPage = () => {
  const [description, setDescription] = useState('');          // For filtering by title
  const [cost, setCost] = useState('');  // For filtering by description
  const [buildingId, setBuildingId] = useState('');
  const [buildings, setBuildings] = useState([]);
  const navigate = useNavigate();

  useEffect(() => {
    axios.get('http://localhost:8080/api/buildings')
      .then(response => {
        setBuildings(response.data);
      })
      .catch(error => {
        console.error('There was an error fetching the buildings!', error);
      });
  }, []);

  const handleSubmit = (e) => {
    e.preventDefault();

    axios.post('http://localhost:8080/api/renovations', {
      description: description,
      cost: cost,
      building_id: buildingId,
    })
    .then(response => {
      console.log('Renovation added!', response.data);
      navigate('/renovations');
    })
    .catch(error => {
      console.error('There was an error adding the renovation!', error);
    });
  };

  return (
    <div>
      <h2>Add a Renovation</h2>
      <form onSubmit={handleSubmit}>
        <div className="form-group">
          <label>Description:</label>
          <input type="text" className="form-control" value={description} onChange={(e) => setDescription(e.target.value)} />
        </div>
        <div className="form-group">
          <label>Cost:</label>
          <input type="number" className="form-control" value={cost} onChange={(e) => setCost(e.target.value)} />
        </div>
        <div className="form-group">
          <label>Building:</label>
          <select className="form-control" value={buildingId} onChange={(e) => setBuildingId(e.target.value)}>
            <option value="">Select Building</option>
            {buildings.map(building => (
              <option key={building.id} value={building.id}>
                {building.name}
              </option>
            ))}
          </select>
        </div>
        <button type="submit" className="btn btn-primary">Add Renovation</button>
      </form>
    </div>
  );
};

export default AddRenovationPage;
