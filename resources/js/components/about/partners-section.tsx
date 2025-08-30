interface Partner {
    id: number;
    name: string;
    logo?: string;
}

interface PartnersSectionProps {
    title: string;
    partners: Partner[];
    className?: string;
}

const PartnersSection = ({ title, partners, className }: PartnersSectionProps) => {
    return (
        <div className={`py-16 ${className}`}>
            <div className="mx-auto max-w-7xl px-4">
                <div className="mb-12 text-center">
                    <h2 className="mb-4 text-3xl font-bold text-gray-900">{title}</h2>
                </div>

                <div className="grid grid-cols-3 gap-6 md:grid-cols-4 lg:grid-cols-6">
                    {partners.map((partner) => (
                        <div
                            key={partner.id}
                            className="flex h-20 w-full items-center justify-center rounded-lg bg-blue-100 transition-colors hover:bg-blue-200"
                        >
                            {partner.logo ? (
                                <img src={partner.logo} alt={partner.name} className="max-h-full max-w-full object-contain" />
                            ) : (
                                <span className="text-center text-sm font-semibold text-blue-600">{partner.name}</span>
                            )}
                        </div>
                    ))}
                </div>
            </div>
        </div>
    );
};

export default PartnersSection;
