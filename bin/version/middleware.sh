if [[ "$(tail -n 1 ~/.zsh_history)" != *"git commit"* ]]; then
    exit 1;
fi
