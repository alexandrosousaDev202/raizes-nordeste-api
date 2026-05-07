import { useEffect, useState } from 'react';
import { 
  Container, Typography, Box, Grid, Badge, AppBar, Toolbar, IconButton,
  Dialog, DialogTitle, DialogContent, DialogActions, TextField, Button,
  List, ListItem, ListItemText, Divider, Chip
} from '@mui/material';
import ShoppingCartIcon from '@mui/icons-material/ShoppingCart';
import AssignmentIcon from '@mui/icons-material/Assignment';
import api from '../services/api';
import ProdutoCard from '../components/ProdutoCard';
import CarrinhoDrawer from '../components/CarrinhoDrawer';

export default function Cardapio() {
  const [produtos, setProdutos] = useState([]);
  const [carrinho, setCarrinho] = useState([]);
  const [carrinhoAberto, setCarrinhoAberto] = useState(false);
  
  const [modalAberto, setModalAberto] = useState(false);
  const [telefone, setTelefone] = useState(localStorage.getItem('@RaizesTelefone') || '');
  const [nome, setNome] = useState(localStorage.getItem('@RaizesNome') || '');

  const [modalPedidosAberto, setModalPedidosAberto] = useState(false);
  const [historicoPedidos, setHistoricoPedidos] = useState([]);

  useEffect(() => {
    api.get('/produtos')
      .then(response => setProdutos(response.data))
      .catch(() => {});
  }, []);

  const adicionarAoCarrinho = (produto) => setCarrinho([...carrinho, produto]);
  const removerDoCarrinho = (index) => setCarrinho(carrinho.filter((_, i) => i !== index));
  const valorTotal = carrinho.reduce((total, item) => total + Number(item.preco), 0);

  const iniciarFinalizacao = () => {
    setCarrinhoAberto(false);
    setModalAberto(true);
  };

  const confirmarPedido = async () => {
    if (!telefone || !nome) {
      alert("Por favor, preencha seu nome e telefone!");
      return;
    }

    try {
      localStorage.setItem('@RaizesTelefone', telefone);
      localStorage.setItem('@RaizesNome', nome);

      const responsePedido = await api.post('/pedidos', {
        usuario_id: 1, 
        unidade_id: 1, 
        canal_pedido: 'web',
        status: 'pendente',
        valor_total: valorTotal
      });

      const pedidoId = responsePedido.data.id;

      for (const item of carrinho) {
        await api.post('/pedido-items', {
          pedido_id: pedidoId,
          produto_id: item.id,
          quantidade: 1,
          preco_unitario: item.preco
        });
      }

      setCarrinho([]);
      setModalAberto(false);
      alert(`🎉 Sucesso, ${nome}! Seu pedido #${pedidoId} já vai para a cozinha!`);
      
    } catch {
      alert('Ops! Erro ao finalizar. Verifique sua conexão.');
    }
  };

  const abrirMeusPedidos = async () => {
    try {
      const response = await api.get('/pedidos');
      setHistoricoPedidos(response.data.reverse()); 
      setModalPedidosAberto(true);
    } catch {
      alert("Não foi possível carregar os pedidos.");
    }
  };

  return (
    <>
      <AppBar position="static" sx={{ backgroundColor: 'primary.main', mb: 4 }} elevation={0}>
        <Container maxWidth="md">
          <Toolbar disableGutters>
            <Typography variant="h6" sx={{ flexGrow: 1, fontWeight: '900', color: 'white' }}>
              Raízes do Nordeste
            </Typography>
            
            <Button 
              color="inherit" 
              onClick={abrirMeusPedidos} 
              sx={{ mr: 2, fontWeight: 'bold' }} 
              startIcon={<AssignmentIcon />}
            >
              Meus Pedidos
            </Button>

            <IconButton color="inherit" onClick={() => setCarrinhoAberto(true)}>
              <Badge badgeContent={carrinho.length} color="secondary">
                <ShoppingCartIcon />
              </Badge>
            </IconButton>
          </Toolbar>
        </Container>
      </AppBar>

      <Container maxWidth="md" sx={{ pb: 10 }}>
        <Typography variant="h5" fontWeight="900" sx={{ mb: 3, color: 'secondary.main' }}>
          Nosso Cardápio
        </Typography>

        <Grid container spacing={3}>
          {produtos.map((produto) => (
            <ProdutoCard key={produto.id} produto={produto} onAdicionar={adicionarAoCarrinho} />
          ))}
        </Grid>
        
        {produtos.length === 0 && <Typography sx={{ mt: 4, textAlign: 'center' }}>Nenhum produto encontrado...</Typography>}

        <CarrinhoDrawer 
          aberto={carrinhoAberto} 
          onClose={() => setCarrinhoAberto(false)}
          carrinho={carrinho}
          onRemover={removerDoCarrinho}
          valorTotal={valorTotal}
          onFinalizar={iniciarFinalizacao}
        />

        <Dialog open={modalAberto} onClose={() => setModalAberto(false)} maxWidth="xs" fullWidth>
          <DialogTitle sx={{ fontWeight: 'bold', textAlign: 'center', pb: 1 }}>
            Faltam algumas informações
          </DialogTitle>
          <DialogContent>
            <Typography variant="body2" color="text.secondary" sx={{ textAlign: 'center', mb: 3 }}>
              Você só precisa preencher estes dados uma vez.
            </Typography>
            <TextField
              autoFocus margin="dense" label="Telefone (WhatsApp)" type="tel" fullWidth variant="outlined"
              value={telefone} onChange={(e) => setTelefone(e.target.value)} sx={{ mb: 2 }}
            />
            <TextField
              margin="dense" label="Seu Nome Completo" type="text" fullWidth variant="outlined"
              value={nome} onChange={(e) => setNome(e.target.value)}
            />
          </DialogContent>
          <DialogActions sx={{ p: 3, pt: 0 }}>
            <Button onClick={confirmarPedido} variant="contained" color="primary" fullWidth size="large" sx={{ fontWeight: 'bold' }}>
              CONFIRMAR
            </Button>
          </DialogActions>
        </Dialog>

        <Dialog open={modalPedidosAberto} onClose={() => setModalPedidosAberto(false)} maxWidth="sm" fullWidth>
          <DialogTitle sx={{ fontWeight: 'bold' }}>Meus Pedidos Recentes</DialogTitle>
          <DialogContent dividers sx={{ p: 0 }}>
            {historicoPedidos.length === 0 ? (
              <Typography sx={{ p: 3, textAlign: 'center' }}>Você ainda não tem pedidos.</Typography>
            ) : (
              <List disablePadding>
                {historicoPedidos.map((pedido) => (
                  <Box key={pedido.id}>
                    <ListItem sx={{ py: 2 }}>
                      <ListItemText 
                        primary={
                          <Typography fontWeight="bold">
                            Pedido #{pedido.id}
                          </Typography>
                        } 
                        secondary={`R$ ${Number(pedido.valor_total).toFixed(2).replace('.', ',')} • ${pedido.canal_pedido}`} 
                      />
                      <Chip 
                        label={pedido.status.toUpperCase()} 
                        color={pedido.status === 'pendente' ? 'warning' : 'success'} 
                        size="small" 
                        sx={{ fontWeight: 'bold' }}
                      />
                    </ListItem>
                    <Divider />
                  </Box>
                ))}
              </List>
            )}
          </DialogContent>
          <DialogActions>
            <Button onClick={() => setModalPedidosAberto(false)} sx={{ fontWeight: 'bold', color: 'text.secondary' }}>
              FECHAR
            </Button>
          </DialogActions>
        </Dialog>

      </Container>
    </>
  );
}