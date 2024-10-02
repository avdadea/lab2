import React, { useState, useEffect } from 'react';
import axios from 'axios';
import { useNavigate } from 'react-router-dom';
import AddChefPage from '../chefs/AddChefPage';

const AddRecipePage = () => {
  const [title, setTitle] = useState('');          // For filtering by title
  const [difficulty, setDifficulty] = useState('');  // For filtering by description
  const [chefId, setChefId] = useState('');
  const [chefs, setChefs] = useState([]);
  const navigate = useNavigate();

  useEffect(() => {
    axios.get('http://localhost:8080/api/chefs')
      .then(response => {
        setChefs(response.data);
      })
      .catch(error => {
        console.error('There was an error fetching the chefs!', error);
      });
  }, []);

  const handleSubmit = (e) => {
    e.preventDefault();

    axios.post('http://localhost:8080/api/recipes', {
      title: title,
      difficulty: difficulty,
      chef_id: chefId,
    })
    .then(response => {
      console.log('Recipe added!', response.data);
      navigate('/recipes');
    })
    .catch(error => {
      console.error('There was an error adding the recipe!', error);
    });
  };

  return (
    <div>
      <h2>Add a Recipe</h2>
      <form onSubmit={handleSubmit}>
        <div className="form-group">
          <label>Title:</label>
          <input type="text" className="form-control" value={title} onChange={(e) => setTitle(e.target.value)} />
        </div>
        <div className="form-group">
          <label>Difficulty:</label>
          <input type="text" className="form-control" value={difficulty} onChange={(e) => setDifficulty(e.target.value)} />
        </div>
        <div className="form-group">
          <label>Chef:</label>
          <select className="form-control" value={chefId} onChange={(e) => setChefId(e.target.value)}>
            <option value="">Select Chef</option>
            {chefs.map(chef => (
              <option key={chef.id} value={chef.id}>
                {chef.name}
              </option>
            ))}
          </select>
        </div>
        <button type="submit" className="btn btn-primary">Add Chef</button>
      </form>
    </div>
  );
};

export default AddRecipePage;
