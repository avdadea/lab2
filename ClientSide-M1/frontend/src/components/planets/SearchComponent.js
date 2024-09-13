import React, { useState } from 'react';
import axios from 'axios';

function SearchComponent({ onSearch }) {
  const [nameQuery, setNameQuery] = useState('');
  const [typeQuery, setTypeQuery] = useState('');

  const handleSearch = async () => {
    try {
      const response = await axios.get('http://127.0.0.1:8000/api/planets', {
        params: { name: nameQuery, type: typeQuery } // Include both name and type in the request
      });
      onSearch(response.data.data); // Pass data to the parent component
    } catch (error) {
      console.error('Error fetching filtered data:', error);
    }
  };

  return (
    <div>
      <input
        type="text"
        placeholder="Search by name..."
        value={nameQuery}
        onChange={(event) => setNameQuery(event.target.value)}
      />
      <input
        type="text"
        placeholder="Search by type..."
        value={typeQuery}
        onChange={(event) => setTypeQuery(event.target.value)}
      />
      <button onClick={handleSearch}>Search</button>
    </div>
  );
}

export default SearchComponent;
