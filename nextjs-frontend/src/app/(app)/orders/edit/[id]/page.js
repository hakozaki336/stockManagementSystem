'use client'
import axios from "axios";
import { useRouter } from "next/navigation";
axios.defaults.withCredentials = true;
import { useEffect, useState } from "react";


const Edit = ({ params }) => {
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
        const isStockInvalid = stock === ''

        return (isCompanyEmpty || isProductEmpty || isStockInvalid);
    }

    const isButtonDisabled = shouldDisableSubmitButton(company, product, stock);
 
    const fetchCompanies = async () => {
        try {
            const response = await axios.get('http://localhost:8000/api/companies');
            const responseData = response.data;

            setCompanies(responseData.data);
        } catch (error) {
            setErrorMessages('情報の取得に失敗しました');
        }
    }

    const fetchProducts = async () => {
        try {
            const response = await axios.get('http://localhost:8000/api/products');
            const responseData = response.data;

            setProducts(responseData.data);
        } catch (error) {
            setErrorMessages('情報の取得に失敗しました');
        }
    }

    const fetchOrder = async () => {
        try {
            const response = await axios.get(`http://localhost:8000/api/orders/${params.id}`);
            setCompany(response.data.company_id);
            setProduct(response.data.product_id);
            setStock(response.data.order_count);
        } catch (error) {
            setErrorMessages('情報の取得に失敗しました');
        }
    }

    const changeCompany = (event) => {
        const selectedCompanyId = event.target.value;
        setCompany(selectedCompanyId);

        shouldDisableSubmitButton();
    };

    const changeProduct = (event) => {
        const selectedProductId = event.target.value;
        setProduct(selectedProductId);

        shouldDisableSubmitButton();
        setStock('');
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

    const EditOrder = async () => {
        try {
            await axios.put(`http://localhost:8000/api/orders/${params.id}`, 
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
        fetchOrder();
    }, [params.id]);

  return (
    <div className="bg-white mx-5 my-5">
            {errorMessages && (
                <div className="bg-red-500 text-white text-sm font-bold p-2 rounded">{errorMessages}</div>
            )}
        <h1 className="p-3 text-2xl font-semibold border-b">注文を編集してください</h1>
        <div className="px-3 ">
            <div className="my-5">
                <div className="flex m-3">
                    <label className="text-xl mr-3 ">企業名:</label>
                    <select name="company_name" className="w-64"
                        value={company}
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
                        value={product}
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
                        value={stock}
                        min="0"
                    />
                </div>
            </div>
            <button
                className="bg-blue-500 hover:bg-blue-600 text-white font-medium px-3 py-1 mb-2 mx-1 font-semibold rounded disabled:cursor-not-allowed disabled:bg-gray-300"
                onClick={EditOrder}
                disabled={isButtonDisabled}
            >
                更新
            </button>
        </div>
    </div>
  )
}

export default Edit