import {BrowserRouter, Routes, Route} from 'react-router-dom';
import './styles/main.scss';
import ListProducts from './components/ListProducts';
import AddProduct from './components/AddProduct';

function App() {
  return (
    <div className="App">
      <BrowserRouter>
        <Routes>
          <Route index element={<ListProducts />} />
          <Route path="/add-product" element={<AddProduct />} />
        </Routes>
       
  
      </BrowserRouter>
    </div>
  );
}

export default App;
