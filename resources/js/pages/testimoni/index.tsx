import { Button } from '@/components/ui/button';
import { Card } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import Layout from '@/layouts/layout';

export default function TestimoniPage() {
    const items = Array.from({ length: 6 }).map((_, i) => ({
        title: 'Lorem Ipsum',
        subtitle: 'Lorem ipsum',
        body: 'Lorem ipsum dolor sit amet consectetur. Aliquet bibendum fringilla cras nisl commodo sit facilisi massa euismod. Sit amet tristique nibh amet sociis mollis. Ornare tellus in et montes. Et pharetra morbi vel mauris faucibus hendrerit fermentum senectus. Ornare viverra elementum at aenean maecenas nunc egestas. Diam arcu nunc aliquam ultricies nisl arcu. Arcu auctor in sit lorem. Interdum tempus vulputate duis tristique risus faucibus dui sagittis dignissim.',
    }));

    return (
        <Layout>
            <div className="mx-auto max-w-screen-xl px-6">
                <h1 className="mb-6 text-center text-3xl font-extrabold">Testimoni</h1>

                {/* Top row (3 cards) */}
                <div className="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    {items.slice(0, 3).map((it, idx) => (
                        <Card key={idx} className="overflow-hidden">
                            <div className="p-4 text-sm text-muted-foreground">{it.body}</div>
                            <div className="flex items-center gap-3 border-t bg-primary/5 p-4">
                                <div className="h-6 w-6 rounded-full bg-primary/30" />
                                <div>
                                    <div className="text-sm font-bold">{it.title}</div>
                                    <div className="text-xs text-muted-foreground">{it.subtitle}</div>
                                </div>
                            </div>
                        </Card>
                    ))}
                </div>

                {/* Bottom row (3 cards) */}
                <div className="mt-6 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    {items.slice(3).map((it, idx) => (
                        <Card key={idx} className="overflow-hidden">
                            <div className="p-4 text-sm text-muted-foreground">{it.body}</div>
                            <div className="flex items-center gap-3 border-t bg-primary/5 p-4">
                                <div className="h-6 w-6 rounded-full bg-primary/30" />
                                <div>
                                    <div className="text-sm font-bold">{it.title}</div>
                                    <div className="text-xs text-muted-foreground">{it.subtitle}</div>
                                </div>
                            </div>
                        </Card>
                    ))}
                </div>

                {/* Submit Feedback */}
                <div className="mt-8 rounded-xl border bg-primary/10 p-6">
                    <h2 className="text-2xl font-extrabold">Submit Your Feedback</h2>
                    <p className="mt-2 text-sm text-muted-foreground">
                        Lorem ipsum dolor sit amet consectetur. Aliquet bibendum fringilla cras nisl commodo sit facilisi massa euismod. Ornare tellus
                        in et montes. Et pharetra morbi vel mauris faucibus hendrerit fermentum senectus. Ornare viverra elementum at aenean maecenas
                        nunc egestas.
                    </p>
                    <div className="mt-4 flex items-center gap-3">
                        <Input placeholder="Type your feedback" className="flex-1" />
                        <Button>Submit</Button>
                    </div>
                </div>
            </div>
        </Layout>
    );
}
