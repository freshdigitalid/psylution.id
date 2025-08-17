import { Card, CardContent } from "@/components/ui/card";
import { Button } from "@/components/ui/button";
import { Badge } from "@/components/ui/badge";
import { Star } from "lucide-react";
import Layout from "@/layouts/layout";
import { usePage } from "@inertiajs/react";
import ReactMarkdown from "react-markdown";
import rehypeRaw from "rehype-raw";

interface Psychologist {
    id: string;
    first_name: string;
    last_name: string;
    education: string;
    experience: string;
    description: string;
    locations: Location[];
    specializations: Specialization[];
}

interface Location {
    location_name: string;
}

interface Specialization {
    specialization_name: string;
}

export default function PsychologistDetail() {
    const { props: { psychologist } }: { props: { psychologist: Psychologist } } = usePage();

    return (
        <Layout>
            <div className="max-w-screen-xl mx-auto px-6 xl:px-0 py-20 space-y-6">
                {/* Header Section */}
                <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
                    {/* Left Card */}
                    <Card className="flex flex-col items-center p-6 text-center space-y-4">
                        <div className="w-32 h-32 rounded-full bg-blue-200" />
                        <ReactMarkdown rehypePlugins={[rehypeRaw]}>
                            {psychologist.description}
                        </ReactMarkdown>
                        <Button>Booking Sesi</Button>
                    </Card>

                    {/* Info Section */}
                    <div className="md:col-span-2 space-y-4">
                        <h1 className="text-2xl font-bold">{psychologist.first_name} {psychologist.last_name}</h1>
                        <p className="text-gray-600">Lorem ipsum</p>

                        <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <p className="font-semibold">Location</p>
                                {psychologist.locations.map((location, index) => (
                                    <p key={index} className="text-gray-600">{location.location_name}</p>
                                ))}
                            </div>
                            <div className="bg-blue-100 h-16 rounded-lg" />

                            <div>
                                <p className="font-semibold">Specialization</p>
                                <div className="flex flex-wrap gap-2 mt-1">
                                    {psychologist.specializations.map((specialization, index) => (
                                        <Badge key={index} variant="secondary">{specialization.specialization_name}</Badge>
                                    ))}
                                </div>
                            </div>

                            <div>
                                <p className="font-semibold">Education</p>
                                <ReactMarkdown rehypePlugins={[rehypeRaw]}>
                                    {psychologist.education}
                                </ReactMarkdown>
                            </div>

                            <div>
                                <p className="font-semibold">Experience</p>
                                <ReactMarkdown rehypePlugins={[rehypeRaw]}>
                                    {psychologist.experience}
                                </ReactMarkdown>
                            </div>
                        </div>
                    </div>
                </div>

                {/* About Section */}
                <section>
                    <h2 className="text-lg font-bold mb-2">About</h2>
                    <p className="text-gray-700 text-sm leading-relaxed">
                        Lorem ipsum dolor sit amet consectetur. Aliquet bibendum fringilla cras
                        nisl commodo sit facilisi massa euismod. Sit amet tristique nibh amet
                        sociis mollis. Ornare tellus in et montes. Et pharetra mollis vel mauris
                        faucibus hendrerit fermentum senectus. Ornare viverra elementum ut
                        aenean nascetur nunc egestas. Diam arcu nunc aliquam ultrices nisl arcu.
                        Arcu auctor in sit lorem. Interdum tempus vulputate duis tristique
                        fusce faucibus dui sagittis dignissim.
                    </p>
                </section>

                {/* Review Section */}
                <section>
                    <Card className="p-6 space-y-4 bg-blue-50 border-blue-200">
                        <h2 className="text-xl font-bold text-center">Review</h2>

                        {Array.from({ length: 2 }).map((_, i) => (
                            <Card key={i} className="p-4">
                                <h3 className="font-semibold">Lorem Ipsum</h3>
                                <div className="flex items-center gap-1 text-blue-500">
                                    {Array.from({ length: 5 }).map((_, i) => (
                                        <Star key={i} size={16} fill="currentColor" stroke="none" />
                                    ))}
                                    <span className="text-xs text-gray-500 ml-2">xxxx</span>
                                </div>
                                <p className="text-gray-700 text-sm leading-relaxed mt-2">
                                    Lorem ipsum dolor sit amet consectetur. Aliquet bibendum fringilla
                                    cras nisl commodo sit facilisi massa euismod. Sit amet tristique
                                    nibh amet sociis mollis. Ornare tellus in et montes. Et pharetra
                                    mollis vel mauris faucibus hendrerit fermentum senectus.
                                </p>
                            </Card>
                        ))}

                        <p className="text-center text-blue-600 text-sm cursor-pointer hover:underline">
                            See More
                        </p>
                    </Card>
                </section>
            </div>
        </Layout>
    );
}
