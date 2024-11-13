import React from 'react';

const DvdDiscForm = ({ onChange }) => {
    return (
        <div id="DVD" className='pl-20'>
            <div className='form-group'>
                <label htmlFor="sizeZ">Size (MB)</label>
                <input type="number" id="size" min="0" step="0.1" name="size" onChange={onChange} className='form-control' />
            </div>

            <p>Please, provide disk space in MB</p>
        </div>
    );
};

export default DvdDiscForm;