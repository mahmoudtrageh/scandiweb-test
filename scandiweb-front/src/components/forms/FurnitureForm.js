import React from 'react';

const FurnitureForm = ({ onChange, errors }) => {
    return (
        <div id="furniture" className='pl-20'>
            <div className='form-group'>
                <label htmlFor="">Height (cm)</label>
                <input type="number" id="height" min="0" step="0.1" name="height" onChange={onChange} className='form-control' />
            </div>

            <div className='form-group'>
                <label htmlFor="">Width (cm)</label>
                <input type="number" id="width" min="0" step="0.1" name="width" onChange={onChange} className='form-control' />
            </div>

            <div className='form-group'>
                <label htmlFor="">Length (cm)</label>
                <input type="number" id="length" min="0" step="0.1" name="length" onChange={onChange} className='form-control' />
            </div>

            <p>Please provide dimensions in HxWxL format</p>
        </div>
    );
};

export default FurnitureForm;