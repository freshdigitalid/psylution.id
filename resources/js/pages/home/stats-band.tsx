import { Card } from '@/components/ui/card';

const items = [
    { value: 'XX', label: 'Lorem ipsum dolor sit amet consectetur.' },
    { value: 'XX', label: 'Lorem ipsum dolor sit amet consectetur.' },
    { value: 'XX', label: 'Lorem ipsum dolor sit amet consectetur.' },
    { value: 'XX', label: 'Lorem ipsum dolor sit amet consectetur.' },
];

export default function StatsBand() {
    return (
        <div className="bg-primary/90 py-6">
            <div className="mx-auto grid max-w-screen-xl grid-cols-2 gap-4 px-6 text-center text-primary-foreground sm:grid-cols-4">
                {items.map((it, idx) => (
                    <Card key={idx} className="border-primary/30 bg-primary/10 p-4">
                        <div className="text-2xl font-bold tracking-tight">{it.value}</div>
                        <p className="mt-1 text-xs opacity-90">{it.label}</p>
                    </Card>
                ))}
            </div>
        </div>
    );
}
