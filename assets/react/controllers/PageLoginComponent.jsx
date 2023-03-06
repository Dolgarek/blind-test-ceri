import React, { useState } from 'react';

function LoginForm() {
  const [username, setUsername] = useState('');
  const [password, setPassword] = useState('');

  const handleSubmit = (event) => {
    event.preventDefault();
    // Vérifiez les informations de connexion ici
  };

  return (
    <form onSubmit={handleSubmit}>
      <label htmlFor="username">Nom d'utilisateur:</label>
      <input
        type="text"
        id="username"
        value={username}
        onChange={(event) => setUsername(event.target.value)}
      />

      <label htmlFor="password">Mot de passe:</label>
      <input
        type="password"
        id="password"
        value={password}
        onChange={(event) => setPassword(event.target.value)}
      />

      <button type="submit">Se connecter</button>
    </form>
  );
}

export default LoginForm;
