interface PodcastSectionProps {
    title: string;
    description?: string;
    videoUrl?: string;
    className?: string;
}

const PodcastSection = ({ title, description, videoUrl, className }: PodcastSectionProps) => {
    return (
        <div className={`py-16 ${className}`}>
            <div className="mx-auto max-w-7xl px-4">
                <div className="mb-12 text-center">
                    <h2 className="mb-4 text-3xl font-bold text-gray-900">{title}</h2>
                    {description && <p className="mx-auto max-w-2xl text-lg text-gray-600">{description}</p>}
                </div>

                <div className="mx-auto w-full max-w-4xl">
                    <div className="flex h-96 w-full items-center justify-center rounded-2xl bg-blue-100">
                        {videoUrl ? (
                            <iframe
                                src={videoUrl}
                                className="h-full w-full rounded-2xl"
                                frameBorder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                allowFullScreen
                            />
                        ) : (
                            <div className="text-center">
                                <div className="mb-4 text-6xl">🎙️</div>
                                <p className="text-lg font-semibold text-blue-600">Podcast Player</p>
                                <p className="mt-2 text-sm text-blue-500">Listen to our latest episodes</p>
                            </div>
                        )}
                    </div>
                </div>
            </div>
        </div>
    );
};

export default PodcastSection;
