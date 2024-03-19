import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import {FaArrowLeft} from "react-icons/fa";
import {Head, useForm} from "@inertiajs/react";
import {useState} from 'react'
import {router} from '@inertiajs/react'
import Comment from "@/Components/Comment.jsx";

export default function CreateTicket({auth, users}) {
    users = Object.values(users)[0];
    const [values, setValues] = useState({
        title: "",
        description: "",
        steps: "",
        assets: "",
        developer: "",
        tester: "",
    })


    function handleSubmit(event) {
        event.preventDefault();


        router.post('/vulns/create', {
            'title': event.target.title.value,
            'description': event.target.description.value,
            'steps': event.target.steps.value,
            'assets': event.target.assets.value,
            'developer': event.target.developer.value,
            'tester': event.target.tester.value,
        })
    }

    return (
        <AuthenticatedLayout user={auth.user}>
            <Head title="Create Ticket"/>
            <div className="flex flex-col items-center justify-center p-16">
                <div className="top_nav flex flex-row p-4 justify-center items-center gap-10">
                    <a className="text-white absolute left-60 flex flex-row items-center justify-center gap-3"
                       href="/vulns"><FaArrowLeft/>Back</a>
                </div>

                <form className="form flex flex-row overview w-4/5 rounded-2xl bg-[#2B2A2A] p-6"
                      onSubmit={handleSubmit}>
                    <div className="left flex flex-col gap-8 justify-center w-1/2 px-8">
                        <div>
                            <p className="title text-[#D0CCCC]">Title</p>
                            <input id="title" className="bg-[#727272] rounded-xl text-white w-full placeholder-white"
                                   placeholder="Enter the title..."/>
                        </div>
                        <div>
                            <p className="description text-[#D0CCCC]">Description</p>
                            <textarea id="description"
                                      className="bg-[#727272] rounded-xl w-gitext-white h-[200px] w-full placeholder-white"
                                      placeholder="Provide a description..."/>
                        </div>

                        <div>
                            <p className="text-[#D0CCCC] text-xl">Steps to reproduce:</p>
                            <textarea id="steps"
                                      className="bg-[#727272] rounded-xl text-white h-[200px] w-full placeholder-white"
                                      placeholder="Provide steps to reproduce..."/>
                        </div>
                    </div>

                    <div className="right flex flex-col gap-8 w-1/2 px-8">
                        <div className="affected_assets flex flex-col gap-2 w-full">
                            <p className="text-[#D0CCCC] text-xl">Affected assets:</p>
                            <textarea id="assets"
                                      className="bg-[#727272] rounded-xl text-white h-[200px] w-full placeholder-white"
                                      placeholder="Provide list of affected assets..."/>
                        </div>
                        <div className="dev_assigned w-full flex flex-col">
                            <p className="w-fit text-white text-xl">Assign developer: </p>
                            <select id="developer" className="bg-[#727272] rounded-xl text-white">
                                <option value={null}>
                                    -None-
                                </option>
                                {users.map((user) => (
                                    <option key={user.id} value={user.id}>
                                        {user.name}
                                    </option>
                                ))}
                            </select>
                        </div>
                        <div className="dev_assigned w-full flex flex-col">
                            <p className="w-fit text-white text-xl">Assign tester: </p>
                            <select id="tester" className="bg-[#727272] rounded-xl text-white">
                                <option value={null}>
                                    -None-
                                </option>
                                {users.map((user) => (
                                    <option key={user.id} value={user.id}>
                                        {user.name}
                                    </option>
                                ))}
                            </select>

                        </div>
                        <div className="flex items-center justify-center">
                            <input type="submit" className="text-white px-8 py-2 rounded-3xl bg-[#4200FF] w-fit"/>
                        </div>
                    </div>

                </form>
            </div>

        </AuthenticatedLayout>
    );
}
