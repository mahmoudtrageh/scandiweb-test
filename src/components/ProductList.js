

import {useNavigate} from 'react-router-dom';
import axios from 'axios';
import { useEffect, useState } from 'react';

export default function ProductList() {

    const [products, setproducts] = useState([]);
    const [selectedProducts, setSelectedProducts] = useState(new Set());

    useEffect(() => {
        getProducts();
        document.title = "Product List"; // Set the page title
    }, []);

    const navigate = useNavigate();

    function getProducts() {
        axios.get('https://scandiweb-test.koomiz.com/api/public/', {
            method: 'GET', 
        }).then(function (response) {
            setproducts(response.data);
        });
    }

    const handleCheckboxChange = (id) => {
        setSelectedProducts((prevSelected) => {
            const updatedSelected = new Set(prevSelected);
            if (updatedSelected.has(id)) {
                updatedSelected.delete(id); 
            } else {
                updatedSelected.add(id); 
            }
            return updatedSelected;
        });
    };

    const AddProduct = () => {
        navigate('/add-product');
    };

    const deleteProducts = () => {
        const productToDelete = Array.from(selectedProducts); // Convert Set to Array
       
        axios.post('https://scandiweb-test.koomiz.com/api/public/products/delete', { ids: productToDelete, method: 'DELETE' })
            .then(response => {
                getProducts(); // Refresh the product list
                setSelectedProducts(new Set()); // Clear selected products
            });
    };

    const formatNumber = (value) => {
        const numValue = Number(value);
        if (Number.isFinite(numValue) && numValue % 1 === 0) {
            return numValue;
        }
        return numValue.toFixed(1);
    };

    return (
        <div className='List product-container'>

            <div className="header-details">
                <h1>Product List</h1>
                <div>
                    <button onClick={AddProduct} className='btn'>ADD</button>
                    <button id="delete-product-btn" className='btn' onClick={deleteProducts}>MASS DELETE</button>
                </div>     
            </div>

            <div className='content'>
                <div className="product-row">
                    {products.map((product, index) => 
                        <div className='product-box' key={index}>
                            <input
                                type="checkbox"
                                name=""
                                className="delete-checkbox"
                                value=""
                                onChange={() => handleCheckboxChange(product.id)}
                            />
                            <div className="product-details">
                                <p>{product.sku}</p> 
                                <h3>{product.name}</h3> 
                                <h3>{product.title}</h3>
                                <p>{product.price} $</p>
                                <p>
                                    {product.size !== null ? (
                                        <>
                                            <strong>Size:</strong> {formatNumber(product.size)} MB
                                        </>
                                    ) : product.weight !== null ? (
                                        <>
                                            <strong>Weight:</strong> {formatNumber(product.weight)}KG
                                        </>
                                    ) : (
                                        <>
                                            <strong>Dimension:</strong> {formatNumber(product.height)}x{formatNumber(product.width)}x{formatNumber(product.length)}
                                        </>
                                    )}
                                </p>
                            </div>
                        </div>
                    )}
                </div>
            </div>
            
            <footer>
                <p>Scandiweb test assignment</p>
            </footer>
        </div>

        
    );
}