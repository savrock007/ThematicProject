import {useEffect, useState} from "react";

export default function Filter() {

    const queryParams = new URLSearchParams(location.search)
    const [params, setParams] = useState({
        text: queryParams.get('text') ?? '', date: queryParams.get('date')??'', status: queryParams.get('status')??''
    });




    return (
        <div className="w-1/5 h-fit bg-[#2B2A2A] rounded-xl flex flex-col justify-start items-center gap-6 py-6">
            <p className="text-white text-2xl w-full text-center">Filter</p>
            <div className="flex flex-col gap-2 w-4/5">
                <p className="text-white">Vulnerability name</p>
                <input className="bg-[#727272] rounded-xl placeholder-white" type="text"
                       placeholder="Vulnerability name"
                       value={params.text}
                    onChange={(event) => {
                       setParams({
                           ...params,
                           text: event.target.value
                       })

                            }}/>

            </div>
            <div className="flex flex-col gap-2 w-4/5">
                <p className="text-white">Vulnerability create date</p>
                <input className="bg-[#727272] rounded-xl text-white" type="date"
                       value={params.date}
                       onChange={(event) => {
                           setParams({
                               ...params,
                               date: event.target.value
                           })}}

                />
            </div>
            <div className="flex flex-col gap-2 w-4/5">
                <p className="text-white">Status</p>
                <select className="bg-[#727272] rounded-xl text-white"
                        value={params.status}
                        onChange={(event) => {
                            setParams({
                                ...params,
                                status: event.target.value
                            })}}
                            >
                    <option value={0}>
                        Any
                    </option>
                    <option value={1}>
                        New
                    </option>
                    <option value={2}>
                        In progress
                    </option>
                    <option value={3}>
                        Testing
                    </option>
                    <option value={4}>
                        Resolved
                    </option>

                </select>
            </div>
            <a className="flex bg-[#4200FF] px-12 py-1 rounded-xl text-white" href={`/vulns?text=${params.text}&date=${params.date}&status=${params.status}`}>Apply</a>
        </div>
    )
}
