import { Button } from '@/components/ui/button';

export default function BookNow() {
    return (
        <section className="mx-auto max-w-screen-xl px-6 pb-10">
            <div className="grid overflow-hidden rounded-lg border sm:grid-cols-[1fr_1fr]">
                <div className="bg-primary/10 p-6">
                    <h3 className="text-lg font-bold">Book Now</h3>
                    <p className="mt-2 text-xs text-muted-foreground">
                        Lorem ipsum dolor sit amet consectetur. Ut viverra volutpat velit vitae volutpat. Lectus vitae sit amet ornare vitae vehicula
                        volutpat eget. Non ultrices tortor non in facilisis. Nunc nec ut mauris feugiat euismod aenean nibh sit amet.
                    </p>
                    <Button className="mt-4">Book</Button>
                </div>
                <div className="hidden bg-muted sm:block" />
            </div>
        </section>
    );
}
