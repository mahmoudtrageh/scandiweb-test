import {BrowserRouter, Routes, Route} from 'react-router-dom';
import './styles/main.scss';
import ProductList from './components/ProductList';
import ProductAdd from './components/ProductAdd';

function App() {
  return (
    <div className="App">
      <BrowserRouter>
        <Routes>
          <Route index element={<ProductList />} />
          <Route path="/add-product" element={<ProductAdd />} />
        </Routes>
       
  
      </BrowserRouter>
    </div>
  );
}

export default App;
