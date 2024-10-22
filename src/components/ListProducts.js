

import {Link, useNavigate} from 'react-router-dom';
import axios from 'axios';
import { useEffect, useState } from 'react';

export default function ListProducts() {

    const [products, setproducts] = useState([]);
    const [selectedProducts, setSelectedProducts] = useState(new Set());
    const navigate = useNavigate();

    useEffect(() => {
        getProducts();
    }, []);

    function getProducts() {
        axios.get('https://scandiweb-test.koomiz.com/', {
            headers: {
                'Content-Type': 'application/json',
            },
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

    const deleteProducts = () => {
        const productToDelete = Array.from(selectedProducts); // Convert Set to Array
       
        axios.post('https://scandiweb-test.koomiz.com/products/delete', { ids: productToDelete, method: 'DELETE' })
            .then(response => {
                getProducts(); // Refresh the product list
                setSelectedProducts(new Set()); // Clear selected products
            })
            .then(function(response){
                navigate('/');
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
                <h1>Products List</h1>
                <div>
                    <Link to="/add-product" className='btn'>ADD</Link>
                    <Link id="delete-product-btn" className='btn' onClick={deleteProducts}>MASS DELETE</Link>
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
                                <h3>{product.sku}</h3> 
                                <h2>{product.name}</h2> 
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
                                            <strong>Dimensions:</strong> {formatNumber(product.height)}x{formatNumber(product.width)}x{formatNumber(product.length)}
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