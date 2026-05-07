import { Grid, Card, CardContent, CardActions, Typography, Button, Box } from '@mui/material';

export default function ProdutoCard({ produto, onAdicionar }) {
  return (
    <Grid item xs={12} sm={6} md={4}>
      <Card 
        elevation={0}
        sx={{ 
          height: '100%', 
          display: 'flex', 
          flexDirection: 'column',
          borderRadius: 4, 
          backgroundColor: 'var(--color-surface)',
          border: '1px solid var(--color-border)',
          transition: 'transform 0.2s',
          '&:hover': {
            transform: 'translateY(-4px)',
            boxShadow: '0 8px 16px var(--color-card-shadow)'
          }
        }}
      >
        <CardContent sx={{ flexGrow: 1, display: 'flex', flexDirection: 'column', p: 3, pb: 0 }}>
          
          <Typography variant="h6" fontWeight="900" color="secondary.main" sx={{ lineHeight: 1.2, mb: 1 }}>
            {produto.nome}
          </Typography>
          
          <Typography variant="body2" color="text.secondary" sx={{ mb: 2 }}>
            {produto.descricao}
          </Typography>
          
          <Box sx={{ mt: 'auto', mb: 2 }}>
            <Typography variant="h5" color="primary.main" fontWeight="900">
              R$ {Number(produto.preco).toFixed(2).replace('.', ',')}
            </Typography>
          </Box>

        </CardContent>
        
        <CardActions sx={{ p: 3, pt: 0 }}>
          <Button 
            onClick={() => onAdicionar(produto)}
            size="large" 
            variant="contained" 
            color="secondary" 
            fullWidth 
            disableElevation
            sx={{ borderRadius: 3, fontWeight: 'bold', textTransform: 'none' }}
          >
            Adicionar à Sacola
          </Button>
        </CardActions>
      </Card>
    </Grid>
  );
}