import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import {Head} from '@inertiajs/react';
import Filter from "@/Components/Filter.jsx";
import VulnCard from "@/Components/VulnCard.jsx";
import {FaPlus} from "react-icons/fa";

export default function VulnList({auth, vulns}) {

    vulns = Object.values(vulns)[0];

    console.log(vulns);


    return (
        <AuthenticatedLayout user={auth.user}>
            <Head title="VulnList"/>
            <div className="flex flex-col gap-2 px-16">

                <div className="h-full py-4">
                    {auth.user.role === 'admin' &&
                        <a className="text-white flex flex-row gap-4 items-center px-8 py-2 rounded-3xl bg-[#4200FF] w-fit"
                           href="/vulns/create">Create
                            Ticket
                            <FaPlus/>
                        </a>
                    }
                </div>

                <div className="flex flex-row gap-10 justify-center">
                    <Filter></Filter>
                    <div className="flex flex-col items-center gap-10 w-4/5 h-full">
                        {vulns.map((vuln) => (
                            <VulnCard key={vuln.id} vuln={vuln}/>
                        ))
                        }
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
