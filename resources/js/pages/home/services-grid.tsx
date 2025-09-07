import { Button } from '@/components/ui/button';
import { Card } from '@/components/ui/card';

const services = Array.from({ length: 6 }).map(() => ({
    title: 'Lorem Ipsum',
    desc: 'Lorem ipsum dolor sit amet consectetur.',
}));

export default function ServicesGrid() {
    return (
        <section className="mx-auto max-w-screen-xl px-6 py-10">
            <h2 className="mb-4 text-xl font-bold">Our Services</h2>
            <div className="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                {services.map((s, i) => (
                    <Card key={i} className="overflow-hidden">
                        <div className="h-36 w-full bg-muted" />
                        <div className="p-4">
                            <div className="text-sm font-semibold">{s.title}</div>
                            <p className="mt-1 text-xs text-muted-foreground">{s.desc}</p>
                            <Button variant="link" className="mt-2 h-auto p-0 text-xs">
                                Learn More
                            </Button>
                        </div>
                    </Card>
                ))}
            </div>
        </section>
    );
}
