import { Drawer, Box, Typography, IconButton, Divider, List, ListItem, ListItemText, Button } from '@mui/material';
import CloseIcon from '@mui/icons-material/Close';

export default function CarrinhoDrawer({ 
  aberto, onClose, carrinho, onRemover, valorTotal, onFinalizar 
}) {
  return (
    <Drawer anchor="right" open={aberto} onClose={onClose}>
      <Box sx={{ width: 'var(--drawer-width)', p: 3, display: 'flex', flexDirection: 'column', height: '100%' }}>
        <Box sx={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', mb: 2 }}>
          <Typography variant="h6" fontWeight="bold">Seu Pedido</Typography>
          <IconButton onClick={onClose}>
            <CloseIcon />
          </IconButton>
        </Box>
        <Divider />

        <List sx={{ flexGrow: 1, overflowY: 'auto' }}>
          {carrinho.length === 0 ? (
            <Typography color="text.secondary" sx={{ mt: 2, textAlign: 'center' }}>
              O carrinho está vazio.
            </Typography>
          ) : (
            carrinho.map((item, index) => (
              <ListItem key={index} disableGutters secondaryAction={
                <IconButton edge="end" color="error" onClick={() => onRemover(index)}>
                  <CloseIcon fontSize="small" />
                </IconButton>
              }>
                <ListItemText 
                  primary={item.nome} 
                  secondary={`R$ ${Number(item.preco).toFixed(2).replace('.', ',')}`} 
                />
              </ListItem>
            ))
          )}
        </List>

        <Divider sx={{ my: 2 }} />
        <Box sx={{ display: 'flex', justifyContent: 'space-between', mb: 3 }}>
          <Typography variant="h6" fontWeight="bold">Total:</Typography>
          <Typography variant="h6" fontWeight="bold" color="success.main">
            R$ {valorTotal.toFixed(2).replace('.', ',')}
          </Typography>
        </Box>
        
        <Button 
          variant="contained" size="large" 
          disabled={carrinho.length === 0} onClick={onFinalizar}
          sx={{ backgroundColor: 'var(--color-btn-finalizar)', '&:hover': { backgroundColor: 'var(--color-btn-finalizar-hover)' } }}
        >
          Finalizar Compra
        </Button>
      </Box>
    </Drawer>
  );
}