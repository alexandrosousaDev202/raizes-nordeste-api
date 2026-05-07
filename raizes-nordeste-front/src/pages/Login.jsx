import { useState } from 'react';
import { Box, Button, Container, TextField, Typography, Alert, Paper } from '@mui/material';
import api from '../services/api';
import { useNavigate } from 'react-router-dom';

export default function Login() {
  const navigate = useNavigate();
  const [email, setEmail] = useState('');
  const [senha, setSenha] = useState('');
  const [erro, setErro] = useState('');

  const handleLogin = async (e) => {
    e.preventDefault();
    setErro('');

    try {
      const response = await api.post('/auth/login', { email, senha });
      const token = response.data.token; 

      if (token) {
        localStorage.setItem('@RaizesToken', token);
        navigate('/cardapio');
      }
    } catch {
      setErro('E-mail ou senha inválidos. Verifique suas credenciais e tente novamente.');
    }
  };

  return (
    <Container maxWidth="xs">
      <Box sx={{ mt: 8, display: 'flex', flexDirection: 'column', alignItems: 'center' }}>
        <Paper elevation={3} sx={{ p: 4, width: '100%', borderRadius: 2 }}>
          
          <Typography component="h1" variant="h5" align="center" fontWeight="bold" gutterBottom>
            Raízes do Nordeste
          </Typography>
          <Typography component="h2" variant="body2" align="center" color="textSecondary" sx={{ mb: 3 }}>
            Acesso ao Sistema de Pedidos
          </Typography>

          {erro && <Alert severity="error" sx={{ mb: 2 }}>{erro}</Alert>}

          <Box component="form" onSubmit={handleLogin} sx={{ mt: 1 }}>
            <TextField
              margin="normal"
              required
              fullWidth
              id="email"
              label="Endereço de E-mail"
              name="email"
              autoComplete="email"
              autoFocus
              value={email}
              onChange={(e) => setEmail(e.target.value)}
            />
            <TextField
              margin="normal"
              required
              fullWidth
              name="senha"
              label="Senha"
              type="password"
              id="senha"
              autoComplete="current-password"
              value={senha}
              onChange={(e) => setSenha(e.target.value)}
            />
            <Button
              type="submit"
              fullWidth
              variant="contained"
              size="large"
              sx={{ mt: 3, mb: 2, py: 1.5, backgroundColor: 'var(--color-btn-login)', '&:hover': { backgroundColor: 'var(--color-btn-login-hover)' } }}
            >
              Entrar
            </Button>
          </Box>
          
        </Paper>
      </Box>
    </Container>
  );
}