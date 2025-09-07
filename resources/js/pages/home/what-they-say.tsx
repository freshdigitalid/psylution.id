import { Button } from '@/components/ui/button';
import { Card } from '@/components/ui/card';

export default function WhatTheySay() {
    return (
        <section className="mx-auto max-w-screen-xl px-6 py-10">
            <h3 className="mb-4 text-center text-xl font-bold">What They Say</h3>
            <div className="space-y-4">
                {[1, 2].map((i) => (
                    <Card key={i} className="p-4">
                        <div className="space-y-2">
                            <div className="text-sm font-semibold">Lorem Ipsum</div>
                            <div className="h-28 w-full rounded-md bg-primary/10 p-3 text-xs text-muted-foreground">
                                Lorem ipsum dolor sit amet consectetur. Aliquet bibendum fringilla eros nisl commodo id facilisi facilisi fringilla
                                arcu tempus nibh mauris enim mollis. Ornare vitae et in senectus. Enim posuere euismod molestie diam facilisis non
                                facilisis neque. Vitae proin id pharetra massa nunc maecenas purus nec proin. Non fermentum cursus ridiculus. Sem nisi
                                taciti mattis fringilla leo enim lorem montes turpis volutpat donec hendrerit ultricies venenatis magna. Nunc a auctor
                                sit at lorem.
                            </div>
                        </div>
                    </Card>
                ))}
                <div className="text-center">
                    <Button variant="link" className="text-xs">
                        See More
                    </Button>
                </div>
            </div>
        </section>
    );
}
