import React, { useState, useEffect } from 'react';
import { useNavigate } from 'react-router-dom';
import axios from 'axios';
import DvdDiscForm from './forms/DvdDiscForm';
import BookForm from './forms/BookForm';
import FurnitureForm from './forms/FurnitureForm';

export default function AddProduct() {
    const [errors, setErrors] = useState('');
    const [inputs, setInputs] = useState({
        sku: '',
        name: '',
        price: '',
        size: null,
        type: '',
        weight: null,
        height: null,
        width: null,
        length: null,
    });
    const [productType, setProductType] = useState('');
    const navigate = useNavigate();

    useEffect(() => {
        document.title = "Product Add"; // Set the page title
    }, []);

    const handleChange = (event) => {
        const name = event.target.name;
        const value = event.target.value;
        setInputs(values => ({ ...values, [name]: value }));
        setErrors(''); // Clear errors on any change
    };

    const goHome = () => {
        navigate('/');
    };
    
    const handleSubmit = (event) => {
        event.preventDefault();
        try {
            axios.post('http://localhost:8000/api/public/products/create', inputs, {
                headers: {
                    'Content-Type': 'application/json',
                },
            })
            .then((response) => {
                // Handle the response data
                if (response.data && response.data.errors) {
                    // Set the error message directly
                    setErrors(response.data.errors);
                } else {
                    goHome();
                }
            })
            .catch((error) => {
                // Handle any axios errors
                if (error.response && error.response.data && error.response.data.errors) {
                    setErrors(error.response.data.errors);
                } else {
                    setErrors('An error occurred. Please try again.');
                }
            });
        } catch (error) {
            console.error("Submit error:", error);
            setErrors('An unexpected error occurred.');
        }
    };

    const handleTypeChange = (event) => {
        const selectedType = event.target.value;
        setProductType(selectedType);
        setInputs((prevInputs) => ({
            ...prevInputs,
            type: selectedType,
        }));
    };
    
    // Mapping product types to their corresponding components
    const productForms = {
        DVD: DvdDiscForm,
        Book: BookForm,
        Furniture: FurnitureForm,
    };

    // Render the selected product form based on productType
    const RenderForm = productForms[productType] || null;

    return (
        <div className='List product-container'>
            <form onSubmit={handleSubmit} method="post" id="product_form">
                <div className="header-details">
                    <h1>Product Add</h1>
                    <div className="buttons">
                        <button type='submit' className='btn'>Save</button>
                        <button type='button' className='btn' onClick={goHome}>Cancel</button>
                    </div>
                </div>
                <div className='form'>
                    {/* Display error message if it exists */}
                    {errors && (
                        <div className="error-message">
                            <small className="text-danger">{errors}</small>
                        </div>
                    )}
                    
                    <div className='form-group'>
                        <label htmlFor="sku">SKU</label>
                        <input type="text" id="sku" name="sku" value={inputs.sku} onChange={handleChange} className='form-control' />
                    </div>

                    <div className='form-group'>
                        <label htmlFor="name">Name</label>
                        <input type="text" id="name" name="name" value={inputs.name} onChange={handleChange} className='form-control' />
                    </div>

                    <div className='form-group'>
                        <label htmlFor="price">Price ($)</label>
                        <input type="number" id="price" min="0" step="0.1" name="price" value={inputs.price} onChange={handleChange} className='form-control' />
                    </div>

                    <div className='form-group'>
                        <label htmlFor="productType">Type Switcher</label>
                        <select name="type" id="productType" value={productType} onChange={handleTypeChange} className='form-control'>
                            <option value="" disabled>Type Switcher</option>
                            <option value="DVD">DVD</option>
                            <option value="Book">Book</option>
                            <option value="Furniture">Furniture</option>
                        </select>
                    </div>

                    {RenderForm && <RenderForm onChange={handleChange}/>}

                </div>
            </form>

            <footer>
                <p>Scandiweb test assignment</p>
            </footer>
        </div>
    );
}