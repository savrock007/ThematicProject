import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import {Head} from '@inertiajs/react';
import Filter from "@/Components/Filter.jsx";
import VulnCard from "@/Components/VulnCard.jsx";

export default function VulnList({auth, vulns}) {

    return (
        <AuthenticatedLayout user={auth.user}>
            <Head title="VulnList"/>

            <div className="flex flex-row gap-10 justify-center p-16">
                <Filter></Filter>
                <div className="flex flex-col items-center gap-10 w-3/4 h-full">
                    {vulns.map((vuln) => (
                        <VulnCard key={vuln.id} vuln={vuln}/>
                    ))
                    }
                </div>

            </div>
        </AuthenticatedLayout>
    );
}
