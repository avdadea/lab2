import React, { useState } from 'react';
import axios from 'axios';

function SearchComponent({ onSearch }) {
  const [nameQuery, setNameQuery] = useState('');
  const [teamNameQuery, setTeamNameQuery] = useState('');

  const handleSearch = async () => {
    try {
      // Log parameters to see if they are being sent
      console.log('Search Params:', { name: nameQuery, team_name: teamNameQuery });

      const response = await axios.get('http://127.0.0.1:8000/api/players', {
        params: { name: nameQuery, team_name: teamNameQuery }
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
        placeholder="Search by Players name..."
        value={nameQuery}
        onChange={(event) => setNameQuery(event.target.value)}
      />
      <input
        type="text"
        placeholder="Search by team name..."
        value={teamNameQuery}
        onChange={(event) => setTeamNameQuery(event.target.value)}
      />
      <button onClick={handleSearch}>Search</button>
    </div>
  );
}

export default SearchComponent;
