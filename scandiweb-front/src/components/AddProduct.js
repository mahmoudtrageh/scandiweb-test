import React, { useState } from 'react';
import { useNavigate } from 'react-router-dom';
import axios from 'axios';
import DvdDiscForm from './forms/DvdDiscForm';
import BookForm from './forms/BookForm';
import FurnitureForm from './forms/FurnitureForm';

export default function AddProduct() {
    const [errors, setErrors] = useState({});
    const [inputs, setInputs] = useState({
        sku: '',
        name: '',
        price: '',
        size: '',
        type: '',
        weight: '',
        height: '',
        width: '',
        length: '',
    });
    const [productType, setProductType] = useState('');
    const navigate = useNavigate();

    const handleChange = (event) => {
        const name = event.target.name;
        const value = event.target.value;
        setInputs(values => ({ ...values, [name]: value }));
        setErrors({ ...errors, [name]: '' }); // Clear specific error on change
    };

    const validate = () => {
        let tempErrors = {};
        let isValid = true;

        // Validation logic here...

        setErrors(tempErrors);
        return isValid;
    };

    const handleSubmit = (event) => {
        event.preventDefault();
        if (validate()) {
            axios.post('https://scandiweb-test.koomiz.com/products/create', inputs, {
                headers: {
                    'Content-Type': 'application/json',
                },
            })
            .then((response) => {
                if (response.data.errors) {
                    setErrors(response.data.errors);
                } else {
                    navigate('/');
                }
            });
            
        }
    };

    const goHome = () => {
        navigate('/');
    };

    const handleTypeChange = (event) => {
        const selectedType = event.target.value;
        setProductType(selectedType);
        // No need to reset common fields
        // Reset only specific fields based on the selected type
        setInputs(prevInputs => {
            const newInputs = { sku: prevInputs.sku, name: prevInputs.name, price: prevInputs.price, type: selectedType };
            return { ...newInputs };
        });
    };

    // Mapping product types to their corresponding components
    const productForms = {
        dvd_disc: DvdDiscForm,
        book: BookForm,
        furniture: FurnitureForm,
    };

    // Render the selected product form based on productType
    const RenderForm = productForms[productType] || null;

    return (
        <div className='List product-container'>
            <form onSubmit={handleSubmit} method="post" id="product_form">
                <div className="header-details">
                    <h1>Add Product</h1>
                    <div className="buttons">
                        <button type='submit' className='btn'>Save</button>
                        <button type='button' className='btn' onClick={goHome}>Cancel</button>
                    </div>
                </div>

                <div className='form'>
                    <p>{errors.errors && <small className="text-danger">{errors.errors}</small>}</p>
                    <div className='form-group'>
                        <label htmlFor="">SKU</label>
                        <input type="text" id="sku" name="sku" value={inputs.sku} onChange={handleChange} className='form-control' />
                    </div>

                    <div className='form-group'>
                        <label htmlFor="">Name</label>
                        <input type="text" id="name" name="name" value={inputs.name} onChange={handleChange} className='form-control' />
                    </div>

                    <div className='form-group'>
                        <label htmlFor="">Price ($)</label>
                        <input type="number" id="price" min="0" step="0.1" name="price" value={inputs.price} onChange={handleChange} className='form-control' />
                    </div>

                    <div className='form-group'>
                        <label htmlFor="">Type Switcher</label>
                        <select name="type" id="productType" value={productType} onChange={handleTypeChange} className='form-control'>
                            <option value="" disabled>Choose Type</option>
                            <option value="dvd_disc">DVD-disc</option>
                            <option value="book">Book</option>
                            <option value="furniture">Furniture</option>
                        </select>
                    </div>

                    {RenderForm && <RenderForm onChange={handleChange} errors={errors} />}

                </div>
            </form>

            <footer>
                <p>Scandiweb test assignment</p>
            </footer>
        </div>
    );
}