import React, { useState, useEffect } from 'react';
import axios from 'axios';
import { Link } from 'react-router-dom';

//expedition==recipe
//explorer==chef
const RecipesList = () => {
  const [recipes, setRecipes] = useState([]);
  const [title, setTitle] = useState('');          // For filtering by title
  const [difficulty, setDifficulty] = useState('');  // For filtering by description
  const [chef, setChef] = useState('');    // For filtering by employee name
  const [successMessage, setSuccessMessage] = useState('');

  // Function to fetch contracts with filters applied
  const fetchRecipes = () => {
    axios.get(`http://localhost:8080/api/recipes?title=${title}&difficulty=${difficulty}&chef=${chef}`)
      .then(response => {
        setRecipes(response.data);
      })
      .catch(error => {
        console.error('There was an error fetching the recipes!', error);
      });
  };

  // Call fetchContracts on component mount and whenever the filters change
  useEffect(() => {
    fetchRecipes();
  }, [title, difficulty, chef]); // Refetch contracts whenever a filter changes

  // Handlers for filter changes
  const handleTitleChange = (e) => {
    setTitle(e.target.value); // Update title filter
  };

  const handleDifficultyChange = (e) => {
    setDifficulty(e.target.value); // Update description filter
  };

  const handleChefChange = (e) => {
    setChef(e.target.value); // Update employee filter
  };

  // Function to delete a contract
  const deleteRecipe = (id) => {
    axios.delete(`http://localhost:8080/api/recipes/${id}`)
      .then(() => {
        setSuccessMessage('Recipe deleted successfully!');
        fetchRecipes(); // Refresh the list after deletion
        setTimeout(() => setSuccessMessage(''), 3000); // Clear success message after 3 seconds
      })
      .catch(error => {
        console.error('There was an error deleting the recipe!', error);
      });
  };

  return (
    <div className="container">
      <h2>Recipes List</h2>
      
      {/* Search Filters */}
      <div className="filters">
        <input 
          type="text" 
          placeholder="Title" 
          value={title} 
          onChange={handleTitleChange} 
          className="form-control" 
          style={{ display: 'inline-block', width: '200px', marginRight: '10px' }}
        />
        <input 
          type="text" 
          placeholder="Difficulty" 
          value={difficulty} 
          onChange={handleDifficultyChange} 
          className="form-control" 
          style={{ display: 'inline-block', width: '200px', marginRight: '10px' }}
        />
        <input 
          type="text" 
          placeholder="Chef Name" 
          value={chef} 
          onChange={handleChefChange} 
          className="form-control" 
          style={{ display: 'inline-block', width: '200px', marginRight: '10px' }}
        />
        <button className="btn btn-primary" onClick={fetchRecipes}>Search</button>
      </div>

      {successMessage && <div className="alert alert-success">{successMessage}</div>} {/* Success message */}

      {/* Add Recipe Link */}
      <div className="text-end">
        <Link to="/add-recipe" className="btn btn-primary">Add Recipes</Link>
      </div>

      {/* Recipe Table */}
      <table className="table">
        <thead>
          <tr>
            <th>No</th>
            <th>Title</th>
            <th>Difficulty</th>
            <th>Chef</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          {recipes.map((recipe, index) => (
            <tr key={recipe.id}>
              <td>{index + 1}</td>
              <td>{recipe.title}</td>
              <td>{recipe.difficulty}</td>
              <td>{recipe.chef.name}</td>
              <td>
                <Link to={`/edit-recipe/${recipe.id}`} className="btn btn-success">Edit</Link>
                <button className="btn btn-danger" onClick={() => deleteRecipe(recipe.id)}>Delete</button>
              </td>
            </tr>
          ))}
        </tbody>
      </table>
    </div>
  );
};

export default RecipesList;
