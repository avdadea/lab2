import React, { useState, useEffect } from 'react';
import axios from 'axios';
import { useParams, useNavigate } from 'react-router-dom';

const EditRenovationPage = () => {
  const { id } = useParams();
  const [description, setDescription] = useState('');          // For filtering by title
  const [cost, setCost] = useState('');  // For filtering by description
  const [buildingId, setBuildingId] = useState('');
  const [buildings, setBuildings] = useState([]);
  const navigate = useNavigate();

  useEffect(() => {
    axios.get(`http://localhost:8080/api/renovations/${id}`)
      .then(response => {
        setDescription(response.data.description);
        setCost(response.data.cost);
        setBuildingId(response.data.building_id);
      })
      .catch(error => {
        console.error('There was an error fetching the renovation!', error);
      });

    axios.get('http://localhost:8080/api/buildings')
      .then(response => {
        setBuildings(response.data);
      })
      .catch(error => {
        console.error('There was an error fetching the buildings!', error);
      });
  }, [id]);

  const handleSubmit = (e) => {
    e.preventDefault();

    axios.put(`http://localhost:8080/api/renovations/${id}`, {
      description: description,
      cost: cost,
      building_id: buildingId,
    })
    .then(response => {
      console.log('Renovation updated!', response.data);
      navigate('/renovations');
    })
    .catch(error => {
      console.error('There was an error updating the renovation!', error);
    });
  };

  return (
    <div>
      <h2>Edit Renovation</h2>
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
        <button type="submit" className="btn btn-primary">Update Renovation</button>
      </form>
    </div>
  );
};

export default EditRenovationPage;
