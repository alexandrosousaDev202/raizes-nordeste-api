import { BrowserRouter, Routes, Route } from 'react-router-dom';
import { createTheme, ThemeProvider, CssBaseline, GlobalStyles } from '@mui/material';
import Login from './pages/Login';
import Cardapio from './pages/Cardapio';

const theme = createTheme({
  palette: {
    mode: 'light',
    primary: {
      main: getComputedStyle(document.documentElement).getPropertyValue('--color-primary').trim() || '#E88D14',
      contrastText: '#fff',
    },
    secondary: {
      main: getComputedStyle(document.documentElement).getPropertyValue('--color-secondary').trim() || '#1A5336',
      contrastText: '#fff',
    },
    background: {
      default: getComputedStyle(document.documentElement).getPropertyValue('--color-background').trim() || '#FDFBF7',
      paper: getComputedStyle(document.documentElement).getPropertyValue('--color-surface').trim() || '#FFFFFF',
    },
    text: {
      primary: getComputedStyle(document.documentElement).getPropertyValue('--color-text-primary').trim() || '#1A5336',
      secondary: getComputedStyle(document.documentElement).getPropertyValue('--color-text-secondary').trim() || '#555555',
    },
  },
  typography: {
    fontFamily: '"Roboto", "Helvetica", "Arial", sans-serif',
  },
});

function App() {
  return (
    <ThemeProvider theme={theme}>
      <CssBaseline />
      <GlobalStyles styles={{ body: { backgroundColor: 'var(--color-background)' } }} />
      <BrowserRouter>
        <Routes>
          <Route path="/" element={<Cardapio />} />
          <Route path="/login" element={<Login />} />
        </Routes>
      </BrowserRouter>
    </ThemeProvider>
  );
}

export default App;