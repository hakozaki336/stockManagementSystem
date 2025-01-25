'use client'
import axios from "axios";
import { useRouter } from "next/navigation";
axios.defaults.withCredentials = true;
import { useState, useEffect } from "react";

const Edit = ({ params }) => {
    const router = useRouter();
    const [errorMessages, setErrorMessages] = useState('');
    const [serialNumber, setSerialNumber] = useState('');
    const [location, setLocation] = useState('');
    const [expirationDate, setExpirationDate] = useState('');

    const shouldDisableSubmitButton = (serialNumber, location, expirationDate) => {
        const isSerialNumberEmpty = !serialNumber;
        const isLocationEmpty = !location;
        const isExpirationDateEmpty = !expirationDate;

        return (isSerialNumberEmpty || isLocationEmpty || isExpirationDateEmpty);
    }

    const isButtonDisabled = shouldDisableSubmitButton(serialNumber, location, expirationDate);

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

    const fetchInventory = async () => {
        try {
            const response = await axios.get(`http://localhost:8000/api/product_inventories/${params.inventory_id}`);
            const responseData = response.data;

            setSerialNumber(responseData.data.serial_number);
            setLocation(responseData.data.location);
            setExpirationDate(responseData.data.expiration_date);
        } catch (error) {
            const message = error.response.data.message
            setErrorMessages(message);
        }
    }

    const changeInventory = async () => {
        try {
            await axios.put(`http://localhost:8000/api/product_inventories/${params.inventory_id}`, 
                {
                    product_id: params.id,
                    serial_number: serialNumber,
                    location: location,
                    expiration_date: expirationDate,
                }
            );
            router.push(`/products/${params.id}/inventories`);
        } catch (error) {
            const message = error.response.data.message
            setErrorMessages(message);
        }
    }

    useEffect(() => {
        fetchInventory();
    }, [params]);

    return (
        <div className="bg-white mx-5 my-5">
            {errorMessages && (
                <div className="bg-red-500 text-white text-sm font-bold p-2 rounded">{errorMessages}</div>
            )}
            <h1 className="p-3 text-2xl font-semibold border-b">在庫を編集してください</h1>
            <div className="px-3 ">
                <div className="my-5">
                    <div className="flex m-3">
                        <label className="text-xl mr-3 ">シリアルナンバー:</label>
                        <input type="text" name="serialNumber"
                            className="w-64"
                            onChange={changeSerialNumber}
                            value={serialNumber}
                        />
                    </div>
                    <div className="flex m-3">
                        <label className="text-xl mr-3 ">保管場所:</label>
                        <input type="text" name="location"
                            className="w-64"
                            onChange={changeLocation}
                            value={location}
                        />
                    </div>
                    <div className="flex m-3">
                        <label className="text-xl mr-3 ">有効期限:</label>
                        <input type="text" name="expirationDate"
                            className="w-64"
                            onChange={changeExpirationDate}
                            value={expirationDate}
                        />
                    </div>
                </div>
                <button
                    className="bg-blue-500 hover:bg-blue-600 text-white font-medium px-3 py-1 mb-2 mx-1 font-semibold rounded disabled:cursor-not-allowed disabled:bg-gray-300"
                    onClick={changeInventory}
                    disabled={isButtonDisabled}
                >
                    更新
                </button>
            </div>
        </div>
    )
}

export default Edit