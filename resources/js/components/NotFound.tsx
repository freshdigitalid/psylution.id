import { Button } from "@/components/ui/button";
import { Link } from "@inertiajs/react";

const NotFound = () => {
    return (
        <div className="min-h-screen flex items-center justify-center p-6 bg-gradient-to-br from-blue-500 to-purple-600">
            <div className="w-full max-w-2xl relative">
                <div className="bg-gray-100/90 backdrop-blur-sm rounded-3xl p-12 text-center shadow-2xl border border-white/20">
                    {/* 404 Number */}
                    <div className="mb-8">
                        <h1 className="text-8xl md:text-9xl font-bold text-gray-800 leading-none">
                            404
                        </h1>
                    </div>
                    
                    {/* Error Message */}
                    <div className="mb-8">
                        <h2 className="text-2xl md:text-3xl font-semibold text-gray-700 mb-4">
                            Sorry, we couldn't find that page
                        </h2>
                    </div>
                    
                    {/* Go Back Button */}
                    <div className="mb-6">
                        <Button 
                            asChild 
                            className="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-full text-lg font-medium transition-all duration-200 transform hover:scale-105"
                        >
                            <Link href="/">
                                Go Back
                            </Link>
                        </Button>
                    </div>
                </div>
                
                {/* Floating Elements */}
                <div className="absolute top-20 left-10 w-20 h-20 bg-white/10 rounded-full blur-xl animate-pulse"></div>
                <div className="absolute bottom-20 right-10 w-32 h-32 bg-white/10 rounded-full blur-xl animate-pulse delay-1000"></div>
            </div>
        </div>
    );
};

export default NotFound;