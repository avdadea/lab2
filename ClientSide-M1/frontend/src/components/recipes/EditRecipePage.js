import React, { useState, useEffect } from 'react';
import axios from 'axios';
import { useParams, useNavigate } from 'react-router-dom';

const EditRecipePage = () => {
  const { id } = useParams();
  const [title, setTitle] = useState('');          // For filtering by title
  const [difficulty, setDifficulty] = useState('');  // For filtering by description
  const [chefId, setChefId] = useState('');
  const [chefs, setChefs] = useState([]);
  const navigate = useNavigate();

  useEffect(() => {
    axios.get(`http://localhost:8080/api/recipes/${id}`)
      .then(response => {
        setTitle(response.data.title);
        setDifficulty(response.data.difficulty);
        setChefId(response.data.chef_id);
      })
      .catch(error => {
        console.error('There was an error fetching the recipe!', error);
      });

    axios.get('http://localhost:8080/api/chefs')
      .then(response => {
        setChefs(response.data);
      })
      .catch(error => {
        console.error('There was an error fetching the chefs!', error);
      });
  }, [id]);

  const handleSubmit = (e) => {
    e.preventDefault();

    axios.put(`http://localhost:8080/api/recipes/${id}`, {
      title: title,
      difficulty: difficulty,
      chef_id: chefId,
    })
    .then(response => {
      console.log('Recipe updated!', response.data);
      navigate('/recipes');
    })
    .catch(error => {
      console.error('There was an error updating the recipe!', error);
    });
  };

  return (
    <div>
      <h2>Edit Recipe</h2>
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
        <button type="submit" className="btn btn-primary">Update Recipe</button>
      </form>
    </div>
  );
};

export default EditRecipePage;
