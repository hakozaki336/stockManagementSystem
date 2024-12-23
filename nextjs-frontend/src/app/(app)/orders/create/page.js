'use client'
import axios from "axios";
import { useRouter } from "next/navigation";
axios.defaults.withCredentials = true;
import { useEffect, useState } from "react";


const Create = () => {
    const router = useRouter();
    const [companies, setCompanies] = useState([]);
    const [products, setProducts] = useState([]);
    const [errorMessages, setErrorMessages] = useState('');
    const [currentStock, setCurrentStock] = useState(0);
    const [product, setProduct] = useState('');
    const [company, setCompany] = useState('');
    const [stock, setStock] = useState('');

    const shouldDisableSubmitButton = (company, product, stock) => {
        const isCompanyEmpty = !company;
        const isProductEmpty = !product;
        const isStockInvalid = stock === '' || parseInt(stock) < 1;

        return (isCompanyEmpty || isProductEmpty || isStockInvalid);
    }

    const isButtonDisabled = shouldDisableSubmitButton(company, product, stock);

    const fetchCompanies = async () => {
        try {
            const response = await axios.get('http://localhost:8000/api/companies/options');
            const responseData = response.data;

            setCompanies(responseData.data);
        } catch (error) {
            setErrorMessages('情報の取得に失敗しました');
        }
    }

    const fetchProducts = async () => {
        try {
            const response = await axios.get('http://localhost:8000/api/products/options');
            const responseData = response.data;

            setProducts(responseData.data);
        } catch (error) {
            setErrorMessages('情報の取得に失敗しました');
        }
    }

    const changeCompany = (event) => {
        setCompany(event.target.value);
        shouldDisableSubmitButton();
    }

    const changeProduct = (event) => {
        setProduct(event.target.value);
        shouldDisableSubmitButton();
    }

    const changeStock = (event) => {
        setStock(event.target.value);
        shouldDisableSubmitButton();

    }

    const handleProduct = (event) => {
        changeProduct(event);
        changeDisplayStock(event);
    }

    const changeDisplayStock = (event) => {
        const targetProduct = products.find((product) => product.id === parseInt(event.target.value));
        if (!targetProduct) {
            setCurrentStock(0);
            return;
        }

        setCurrentStock(targetProduct.stock);
    }

    const createOrder = async () => {
        try {
            await axios.post('http://localhost:8000/api/orders', 
                {
                    company_id: company,
                    product_id: product,
                    order_count: stock
                }
            );
            router.push(`/orders`)
        } catch (error) {
            const message = error.response.data.message
            setErrorMessages(message);
        }
    }


    useEffect(() => {
        fetchCompanies();
        fetchProducts();
    }, []);

  return (
    <div className="bg-white mx-5 my-5">
            {errorMessages && (
                <div className="bg-red-500 text-white text-sm font-bold p-2 rounded">{errorMessages}</div>
            )}
        <h1 className="p-3 text-2xl font-semibold border-b">注文を登録してください</h1>
        <div className="px-3 ">
            <div className="my-5">
                <div className="flex m-3">
                    <label className="text-xl mr-3 ">企業名:</label>
                    <select name="company_name" className="w-64"
                        onChange={changeCompany}
                    >
                        <option value="">選択してください</option>
                        {companies.map((company) => (
                            <option key={company.id} value={company.id}>
                                {company.name}
                            </option>
                        ))}
                    </select>
                </div>
                <div className="flex m-3">
                    <label className="text-xl mr-3">商品名:</label>
                    <select name="product_name"
                        className="w-64"
                        onChange={handleProduct}
                    >
                        <option value="">選択してください</option>
                        {products.map((product) => (
                            <option key={product.id} value={product.id}>
                                {product.name}
                            </option>
                        ))}
                    </select>
                </div>
                <div className="flex m-3">
                    <label className="text-xl mr-3">注文数:</label>
                    <input type="number" name="order_count"
                        className="w-64"
                        onChange={changeStock}
                        placeholder={`現在の在庫数: ${currentStock}`}
                        min="0"
                    />
                </div>
            </div>
            <button
                className="bg-blue-500 hover:bg-blue-600 text-white font-medium px-3 py-1 mb-2 mx-1 font-semibold rounded disabled:cursor-not-allowed disabled:bg-gray-300"
                onClick={createOrder}
                disabled={isButtonDisabled}
            >
                追加
            </button>
        </div>
    </div>
  )
}

export default Create