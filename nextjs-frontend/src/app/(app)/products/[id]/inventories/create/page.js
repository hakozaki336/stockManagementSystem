'use client'
import axios from "axios";
import { useRouter } from "next/navigation";
axios.defaults.withCredentials = true;
import React, { useEffect, useState } from 'react';


const Create = ({ params }) => {
    const router = useRouter();
    const [product, setProduct] = useState('');
    const [errorMessages, setErrorMessages] = useState('');
    const [serial_number, setSerialNumber] = useState('');
    const [location, setLocation] = useState('');
    const [expirationDate, setExpirationDate] = useState('');

    const shouldDisableSubmitButton = (serialNumber, location, expirationDate) => {
        const isSerialNumberEmpty = !serialNumber;
        const isLocationEmpty = !location;
        const isExpirationDateEmpty = !expirationDate;

        return (isSerialNumberEmpty || isLocationEmpty || isExpirationDateEmpty);
    }

    const isButtonDisabled = shouldDisableSubmitButton(serial_number, location, expirationDate);

    const changeSerialNumber = (event) => {
        setSerialNumber(event.target.value);
        shouldDisableSubmitButton();
    }

    const changeLocation = (event) => {
        setLocation(event.target.value);
        shouldDisableSubmitButton();
    }

    const changeExpirationDate = (event) => {
        setExpirationDate(event.target.value);
        shouldDisableSubmitButton();
    }

    const fetchProduct = async () => {
        try {
            const response = await axios.get(`http://localhost:8000/api/products/${params.id}`);
            const responseData = response.data;

            setProduct(responseData);
        } catch (error) {
            setErrorMessages('情報の取得に失敗しました');
        }
    }

    const createInventory = async () => {
        try {
            await axios.post(`http://localhost:8000/api/product_inventories`, 
                {
                    product_id: params.id,
                    serial_number: serial_number,
                    location: location,
                    expiration_date: expirationDate
                }
            );
            router.push(`/products/${params.id}/inventories`);
        } catch (error) {
            const message = error.response.data.message
            setErrorMessages(message);
        }
    }

    useEffect(() => {
        fetchProduct(params.id);
    } ,[params]);

  return (
    <div className="bg-white mx-5 my-5">
            {errorMessages && (
                <div className="bg-red-500 text-white text-sm font-bold p-2 rounded">{errorMessages}</div>
            )}
        <h1 className="p-3 text-2xl font-semibold border-b">「{ product.name }」の在庫を追加してください</h1>
        <div className="px-3 ">
            <div className="my-5">
                <div className="flex m-3">
                    <label className="text-xl mr-3">シリアルナンバー :</label>
                    <input type="text" name="price"
                        className="w-64"
                        onChange={changeSerialNumber}
                    />
                </div>
                <div className="flex m-3">
                    <label className="text-xl mr-3">保管場所　　　　:</label>
                    <input type="text" name="price"
                        className="w-64"
                        onChange={changeLocation}
                    />
                </div>
                <div className="flex m-3">
                    <label className="text-xl mr-3">有効期限　　　　:</label>
                    <input type="date" name="price"
                        className="w-64"
                        onChange={changeExpirationDate}
                    />
                </div>
            </div>
            <button
                className="bg-blue-500 hover:bg-blue-600 text-white font-medium px-3 py-1 mb-2 mx-1 font-semibold rounded disabled:cursor-not-allowed disabled:bg-gray-300"
                onClick={createInventory}
                disabled={isButtonDisabled}
            >
                追加
            </button>
        </div>
    </div>
  )
}

export default Create