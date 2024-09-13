import React, { useState } from 'react';
import axios from 'axios';

function SearchComponent({ onSearch }) {
  const [nameQuery, setNameQuery] = useState('');
  const [planetNameQuery, setPlanetNameQuery] = useState('');

  const handleSearch = async () => {
    try {
      // Log parameters to see if they are being sent
      console.log('Search Params:', { name: nameQuery, planet_name: planetNameQuery });

      const response = await axios.get('http://127.0.0.1:8000/api/satellites', {
        params: { name: nameQuery, planet_name: planetNameQuery }
      });

      // Check the response data structure
      console.log('API Response Data:', response.data.data);
      onSearch(response.data.data);
    } catch (error) {
      console.error('Error fetching filtered data:', error);
    }
  };

  return (
    <div>
      <input
        type="text"
        placeholder="Search by satellite name..."
        value={nameQuery}
        onChange={(event) => setNameQuery(event.target.value)}
      />
      <input
        type="text"
        placeholder="Search by planet name..."
        value={planetNameQuery}
        onChange={(event) => setPlanetNameQuery(event.target.value)}
      />
      <button onClick={handleSearch}>Search</button>
    </div>
  );
}

export default SearchComponent;
